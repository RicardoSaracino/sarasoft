<?php

namespace AppBundle\Controller;

use CommerceGuys\Tax\Resolver\TaxType\ChainTaxTypeResolver;
use CommerceGuys\Tax\Resolver\TaxType\CanadaTaxTypeResolver;
use CommerceGuys\Tax\Resolver\TaxType\DefaultTaxTypeResolver;
use CommerceGuys\Tax\Resolver\TaxRate\ChainTaxRateResolver;
use CommerceGuys\Tax\Resolver\TaxRate\DefaultTaxRateResolver;
use CommerceGuys\Tax\Resolver\TaxResolver;
use CommerceGuys\Tax\Resolver\Context;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomerOrder;

use AppBundle\Form\Type\HiddenEntityType;

/**
 * CustomerOrder controller.
 *
 * @Route("customerorder")
 */
class CustomerOrderController extends Controller
{
	/**
	 * @param CustomerOrder $customerOrder
	 * @return \AppBundle\Entity\TaxRateAmount[]
	 */
	protected function getTaxRateAmounts(CustomerOrder $customerOrder)
	 {
		 /** @var \AppBundle\Repository\TaxTypeRepository $taxTypeRepository */
		 $taxTypeRepository = $this->getDoctrine()->getRepository('AppBundle:TaxType');

		 $chainTaxTypeResolver = new ChainTaxTypeResolver();
		 $chainTaxTypeResolver->addResolver(new DefaultTaxTypeResolver($taxTypeRepository));
		 $chainTaxRateResolver = new ChainTaxRateResolver();
		 $chainTaxRateResolver->addResolver(new DefaultTaxRateResolver());
		 $resolver = new TaxResolver($chainTaxTypeResolver, $chainTaxRateResolver);

		 $context = new Context($customerOrder->getCustomer()->getAddress(), $customerOrder->getCompany()->getAddress());
		 $context->setDate($customerOrder->getCompletedAt());

		 /** @var \AppBundle\Entity\TaxRateAmount $taxRateAmounts */
		 return $resolver->resolveAmounts($customerOrder, $context);
	 }

	/**
	 * @param CustomerOrder $customerOrder
	 */
	protected function calculateInvoiceAmounts(CustomerOrder &$customerOrder)
	{
		$invoiceSubtotal = new \Money\Money(0, new \Money\Currency('CAD'));

		/** @var \AppBundle\Repository\ServicePriceRepository $servicePriceRepository */
		$servicePriceRepository = $this->getDoctrine()->getRepository('AppBundle:ServicePrice');

		foreach ($customerOrder->getCustomerOrderServices() as $customerOrderService) {

			$servicePrice = $servicePriceRepository->findEffective($customerOrderService->getService(),$customerOrder->getCompletedAt());

			$customerOrderService->setInvoicePrice($servicePrice->getPrice());

			$invoiceSubtotal = $invoiceSubtotal->add($servicePrice->getPrice()->multiply($customerOrderService->getQuantity()));
		}

		/** @var \AppBundle\Repository\ProductPriceRepository $productPriceRepository */
		$productPriceRepository = $this->getDoctrine()->getRepository('AppBundle:ProductPrice');

		foreach ($customerOrder->getCustomerOrderProducts() as $customerOrderProduct) {

			$productPrice = $productPriceRepository->findEffective($customerOrderProduct->getProduct(),$customerOrder->getCompletedAt());

			$customerOrderProduct->setInvoicePrice($productPrice->getPrice());

			$invoiceSubtotal = $invoiceSubtotal->add($productPrice->getPrice()->multiply($customerOrderProduct->getQuantity()));
		}

		$invoiceTotal = $invoiceSubtotal;

		$customerOrderTaxRateAmounts = new \Doctrine\Common\Collections\ArrayCollection();

		foreach ($this->getTaxRateAmounts($customerOrder) as $taxRateAmount) {

			$taxes = $invoiceSubtotal->divide($taxRateAmount->getAmount());

			$customerOrderTaxRateAmount = new \AppBundle\Entity\CustomerOrderTaxRateAmount();
			$customerOrderTaxRateAmount->setTaxes($taxes);
			$customerOrderTaxRateAmount->setTaxRateAmount($taxRateAmount);
			$customerOrderTaxRateAmount->setCustomerOrder($customerOrder);
			$customerOrderTaxRateAmounts->add($customerOrderTaxRateAmount);

			## Add tax to subtotal
			$invoiceTotal = $invoiceTotal->add($taxes);
		}

		$customerOrder->setCustomerOrderTaxRateAmounts($customerOrderTaxRateAmounts);
		$customerOrder->setInvoiceSubtotal($invoiceSubtotal);
		$customerOrder->setInvoiceTotal($invoiceTotal);
	}

	/**
	 * @param CustomerOrder $customerOrder
	 * @return mixed
	 */
	protected function emailInvoice(CustomerOrder $customerOrder)
	{
		$message = \Swift_Message::newInstance()
			->setSubject($customerOrder->getCompany()->getName() . ' ' . 'Invoice')
			->setFrom($customerOrder->getCompany()->getEmail())
			->setTo($customerOrder->getCustomer()->getEmail())
			->setBody(
				$this->renderView(
					'customerorder/email_invoice.html.twig',
					[
						'customerOrder' => $customerOrder,
					]
				),
				'text/html'
			);

		return $this->get('mailer')->send($message);
	}

	#################################################
	## LIST
	#################################################

	/**
	 * Lists all customerOrder entities.
	 *
	 * @Route("/", name="customer_order_list_all")
	 * @Method({"GET", "POST"})
	 */
	public function listAllAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findAll();

		return $this->render(
			'customerorder/list_all.html.twig',
			[
				'customerOrders' => $customerOrders,
			]
		);
	}

	/**
	 * Lists all customerOrder entities.
	 *
	 * @Route("/customer/{customer_id}/list", name="customer_order_list_all_customer")
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "customer_id"}})
	 * @Method({"GET", "POST"})
	 */
	public function listCustomerAllAction(Request $request, Customer $customer)
	{
		return $this->render(
			'customerorder/list_all.html.twig',
			[
				'customerOrders' => $this->getDoctrine()->getManager()->getRepository('AppBundle:CustomerOrder')->findByCustomer($customer)
			]
		);
	}

	/**
	 * Lists all booked customerOrder entities.
	 *
	 * @Route("/list/booked", name="customer_order_list_booked")
	 * @Method({"GET", "POST"})
	 */
	public function listBookedAction(Request $request)
	{
		return $this->render(
			'customerorder/list_booked.html.twig',
			[
				'customerOrders' => $this->getDoctrine()->getManager()->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_BOOKED)
			]
		);
	}

	/**
	 * Lists all in progress customerOrder entities.
	 *
	 * @Route("/list/inprogress", name="customer_order_list_inprogress")
	 * @Method({"GET", "POST"})
	 */
	public function listInProgressAction(Request $request)
	{
		return $this->render(
			'customerorder/list_inprogress.html.twig',
			[
				'customerOrders' => $this->getDoctrine()->getManager()->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_INPROGRESS)
			]
		);
	}

	/**
	 * Lists all complete customerOrder entities.
	 *
	 * @Route("/list/complete", name="customer_order_list_complete")
	 * @Method({"GET", "POST"})
	 */
	public function listCompleteAction(Request $request)
	{
		return $this->render(
			'customerorder/list_complete.html.twig',
			[
				'customerOrders' => $this->getDoctrine()->getManager()->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_COMPLETE)
			]
		);
	}

	/**
	 * Lists all invoiced customerOrder entities.
	 *
	 * @Route("/list/invoiced", name="customer_order_list_invoiced")
	 * @Method({"GET", "POST"})
	 */
	public function listInvoicedAction(Request $request)
	{

		return $this->render(
			'customerorder/list_invoiced.html.twig',
			[
				'customerOrders' => $this->getDoctrine()->getManager()->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_INVOICED)
			]
		);
	}

	/**
	 * Lists all paid customerOrder entities.
	 *
	 * @Route("/list/paid", name="customer_order_list_paid")
	 * @Method({"GET", "POST"})
	 */
	public function listPaidAction(Request $request)
	{
		return $this->render(
			'customerorder/list_paid.html.twig',
			[
				'customerOrders' => $this->getDoctrine()->getManager()->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_PAID)
			]
		);
	}

	/**
	 * Lists all booked customerOrder entities.
	 *
	 * @Route("/list/cancelled", name="customer_order_list_cancelled")
	 * @Method({"GET", "POST"})
	 */
	public function listCancelledAction(Request $request)
	{
		return $this->render(
			'customerorder/list_cancelled.html.twig',
			[
				'customerOrders' => $this->getDoctrine()->getManager()->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_CANCELLED)
			]
		);
	}

	#################################################
	## SHOW
	#################################################

	/**
	 * Finds and displays a customerOrder entity.
	 *
	 * @Route("/{id}", name="show_customer_order")
	 * @Method("GET")
	 */
	public function showAction(CustomerOrder $customerOrder)
	{
		return $this->render(
			'customerorder/show.html.twig',
			[
				'customerOrder' => $customerOrder,
			]
		);
	}

	/**
	 * Finds and displays an invoiced customerOrder entity.
	 *
	 * @Route("/{id}/show/invoice", name="customer_order_show_invoice")
	 * @Method("GET")
	 */
	public function showEmailInvoiceAction(CustomerOrder $customerOrder)
	{
		$this->calculateInvoiceAmounts($customerOrder);

		return $this->render(
			'customerorder/email_invoice.html.twig',
			[
				'customerOrder' => $customerOrder
			]
		);
	}

	#################################################
	## NEW
	#################################################

	/**
     * Creates a new booked customerOrder entity.
     *
     * @Route("/customer/{customer_id}/new/booked", name="customer_order_new_booked")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
     */
    public function newBookedAction(Request $request, Customer $customer)
    {
        $customerOrder = new CustomerOrder();

		$customerOrder->setCustomer($customer);

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderNewStatusBookedType::class, $customerOrder, ['validation_groups' => ['NewStatusBooked']]);

		$form->add('customer', HiddenEntityType::class, ['class' => Customer::class, 'data' => $customer]);

        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_BOOKED);

			$em = $this->getDoctrine()->getManager();

			$em->persist($customerOrder);

			$em->flush();

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/new_inprogress.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView(),
			]
		);
    }
	/**
     * Creates a new inprogress customerOrder entity.
     *
     * @Route("/customer/{customer_id}/new/inprogress", name="customer_order_new_inprogress")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
     */
    public function newInProgressAction(Request $request, Customer $customer)
    {
        $customerOrder = new CustomerOrder();

		## make sure we have at least one
		if( $customerOrder->getCustomerOrderProducts()->isEmpty() ){
			$customerOrder->addCustomerOrderProduct(new \AppBundle\Entity\CustomerOrderProduct());
		}

		## make sure we have at least one
		if( $customerOrder->getCustomerOrderServices()->isEmpty() ){
			$customerOrder->addCustomerOrderService(new \AppBundle\Entity\CustomerOrderService());
		}

		$customerOrder->setCustomer($customer);

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderNewStatusInProgressType::class, $customerOrder, ['validation_groups' => ['NewStatusInProgress']]);

		$form->add('customer', HiddenEntityType::class, ['class' => Customer::class, 'data' => $customer]);

        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_INPROGRESS);

			$em = $this->getDoctrine()->getManager();

			$em->persist($customerOrder);

			$em->flush();

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/new_inprogress.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView(),
			]
		);
    }

	/**
     * Creates a new booked customerOrder entity.
     *
     * @Route("/customer/{customer_id}/new/complete", name="customer_order_new_complete")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
     */
    public function newCompleteAction(Request $request, Customer $customer)
    {
        $customerOrder = new CustomerOrder();

		## make sure we have at least one
		if( $customerOrder->getCustomerOrderProducts()->isEmpty() ){
			$customerOrder->addCustomerOrderProduct(new \AppBundle\Entity\CustomerOrderProduct());
		}

		## make sure we have at least one
		if( $customerOrder->getCustomerOrderServices()->isEmpty() ){
			$customerOrder->addCustomerOrderService(new \AppBundle\Entity\CustomerOrderService());
		}

		$customerOrder->setCustomer($customer);

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderNewStatusCompleteType::class, $customerOrder, ['validation_groups' => ['NewStatusComplete']]);

		$form->add('customer', HiddenEntityType::class, ['class' => Customer::class, 'data' => $customer]);

        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_COMPLETE);

			$em = $this->getDoctrine()->getManager();

			$em->persist($customerOrder);

			$em->flush();

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/new_inprogress.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView(),
			]
		);
    }

	#################################################
	## EDIT
	#################################################

    /**
     * Displays a form to edit an existing booked customerOrder entity.
     *
     * @Route("/{id}/edit/book", name="customer_order_edit_booked")
     * @Method({"GET", "POST"})
     */
    public function editBookedAction(Request $request, CustomerOrder $customerOrder)
    {
		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderEditStatusBookedType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['EditStatusBooked']]);

        $form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_BOOKED])) {

			$form->addError(new \Symfony\Component\Form\FormError('Cannot Book Order'));
		}

        if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_BOOKED);

			$this->getDoctrine()->getManager()->flush();

			if ($request->request->get('customerOrder_status_inprogress')) {
				return $this->redirectToRoute('customer_order_edit_inprogress', ['id' => $customerOrder->getId()]);

			} else {
				if ($request->request->get('customerOrder_status_complete')) {
					return $this->redirectToRoute('customer_order_edit_complete', ['id' => $customerOrder->getId()]);

				} else {
					if ($request->request->get('customerOrder_status_cancelled')) {
						return $this->redirectToRoute('customer_order_edit_cancelled', ['id' => $customerOrder->getId()]);
					}
				}
			}

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/edit_booked.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView()
			]
		);
	}


	/**
	 * Displays a form to edit or set inprogress an existing customerOrder entity.
	 *
	 * @Route("/{id}/edit/inprogress", name="customer_order_edit_inprogress")
	 * @Method({"GET", "POST"})
	 */
	public function editInProgressAction(Request $request, CustomerOrder $customerOrder)
	{
		## make sure we have at least one
		if( $customerOrder->getCustomerOrderProducts()->isEmpty() ){
			$customerOrder->addCustomerOrderProduct(new \AppBundle\Entity\CustomerOrderProduct());
		}

		## make sure we have at least one
		if( $customerOrder->getCustomerOrderServices()->isEmpty() ){
			$customerOrder->addCustomerOrderService(new \AppBundle\Entity\CustomerOrderService());
		}

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderEditStatusInProgressType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['EditStatusInProgress']]);

		$form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_BOOKED, CustomerOrder::STATUS_INPROGRESS])) {
			$form->addError(new \Symfony\Component\Form\FormError('Cannot Progress Order'));
		}

        if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_INPROGRESS);

			$this->getDoctrine()->getManager()->flush();

			if ($request->request->get('customerOrder_status_complete')) {
				return $this->redirectToRoute('customer_order_edit_complete', ['id' => $customerOrder->getId()]);
			}

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/edit_inprogress.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView()
			]
		);
	}

	/**
     * Displays a form to edit or complete an existing customerOrder entity.
     *
     * @Route("/{id}/edit/complete", name="customer_order_edit_complete")
     * @Method({"GET", "POST"})
     */
    public function editCompleteAction(Request $request, CustomerOrder $customerOrder)
    {
    	## make sure we have at least one
		if( $customerOrder->getCustomerOrderProducts()->isEmpty() ){
			$customerOrder->addCustomerOrderProduct(new \AppBundle\Entity\CustomerOrderProduct());
		}

		## make sure we have at least one
		if( $customerOrder->getCustomerOrderServices()->isEmpty() ){
			$customerOrder->addCustomerOrderService(new \AppBundle\Entity\CustomerOrderService());
		}

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderEditStatusCompleteType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['EditStatusComplete']]);

		$form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_BOOKED, CustomerOrder::STATUS_INPROGRESS, CustomerOrder::STATUS_COMPLETE])) {
			$form->addError(new \Symfony\Component\Form\FormError('Cannot Complete Order'));
		}

        if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_COMPLETE);

			$this->getDoctrine()->getManager()->flush();

			if ($request->request->get('customerOrder_status_invoiced')) {
				return $this->redirectToRoute('customer_order_edit_invoice', ['id' => $customerOrder->getId()]);
			}

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/edit_completed.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView()
			]
		);
	}

	/**
     * Displays a form to edit or complete an existing customerOrder entity.
     *
     * @Route("/{id}/edit/invoice", name="customer_order_edit_invoice")
     * @Method({"GET", "POST"})
     */
    public function editInvoiceAction(Request $request, CustomerOrder $customerOrder)
    {
		$this->calculateInvoiceAmounts($customerOrder);

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderEditStatusInvoicedType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['EditStatusInvoiced']]);

		$form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_COMPLETE, CustomerOrder::STATUS_INVOICED])) {
			$form->addError(new \Symfony\Component\Form\FormError('Cannot Invoice Order'));
		}

        if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_INVOICED);

			if($request->request->get('customerOrder_sendInvoice')) {
				$customerOrder->setInvoiceEmailedAt(new \DateTime());
				#$customerOrder->
			}


			$this->getDoctrine()->getManager()->flush();

			if ($request->request->get('customerOrder_status_paid')) {
				return $this->redirectToRoute('customer_order_edit_paid', ['id' => $customerOrder->getId()]);
			}

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/edit_invoiced.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView()
			]
		);
	}

	/**
     * Displays a form to edit or pay an existing customerOrder entity.
     *
     * @Route("/{id}/edit/paid", name="customer_order_edit_paid")
     * @Method({"GET", "POST"})
     */
    public function editPaidAction(Request $request, CustomerOrder $customerOrder)
    {


		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderEditStatusPaidType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['EditStatusPaid']]);

		$form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_COMPLETE, CustomerOrder::STATUS_INVOICED, CustomerOrder::STATUS_PAID])) {
			$form->addError(new \Symfony\Component\Form\FormError('Cannot Invoice Order'));
		}


        if ($form->isSubmitted() && $form->isValid()) {
			dump($form); die;

			$customerOrder->setStatus(CustomerOrder::STATUS_PAID);

			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/edit_paid.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView()
			]
		);
	}

	/**
	 * Displays a form to edit or cancel an existing customerOrder entity.
	 *
	 * @Route("/{id}/edit/cancel", name="customer_order_edit_cancelled")
	 * @Method({"GET", "POST"})
	 */
	public function editCancelAction(Request $request, CustomerOrder $customerOrder)
	{
		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderEditStatusCancelledType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['EditStatusCancelled']]);

		$form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_BOOKED, CustomerOrder::STATUS_CANCELLED])) {
			$form->addError(new \Symfony\Component\Form\FormError('Cannot Cancel Order'));
		}

        if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_CANCELLED);

			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
		}

        return $this->render(
			'customerorder/edit_cancelled.html.twig',
			[
				'customerOrder' => $customerOrder,
				'form' => $form->createView()
			]
		);
	}
}
