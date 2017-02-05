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
	 * Lists all customerOrder entities.
	 *
	 * @Route("/", name="customer_order_list_all")
	 * @Method({"GET", "POST"})
	 */
	public function listAllAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findAll();

		return $this->render('customerorder/list_all.html.twig', [
			'customerOrders' => $customerOrders,
		]);
	}

	/**
	 * Lists all booked customerOrder entities.
	 *
	 * @Route("/list/booked", name="customer_order_list_booked")
	 * @Method({"GET", "POST"})
	 */
	public function listBookedAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_BOOKED);

		return $this->render('customerorder/list_booked.html.twig', [
			'customerOrders' => $customerOrders,
		]);
	}


	/**
	 * Lists all booked customerOrder entities.
	 *
	 * @Route("/list/cancelled", name="customer_order_list_cancelled")
	 * @Method({"GET", "POST"})
	 */
	public function listCancelledAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_CANCELLED);

		return $this->render('customerorder/list_cancelled.html.twig', [
			'customerOrders' => $customerOrders,
		]);
	}


	/**
	 * Lists all in progress customerOrder entities.
	 *
	 * @Route("/list/inprogress", name="customer_order_list_inprogress")
	 * @Method({"GET", "POST"})
	 */
	public function listInProgressAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_INPROGRESS);

		return $this->render('customerorder/list_inprogress.html.twig', [
			'customerOrders' => $customerOrders,
		]);
	}

	/**
	 * Lists all complete customerOrder entities.
	 *
	 * @Route("/list/complete", name="customer_order_list_complete")
	 * @Method({"GET", "POST"})
	 */
	public function listCompleteAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_COMPLETE);

		return $this->render('customerorder/list_complete.html.twig', [
			'customerOrders' => $customerOrders,
		]);
	}

	/**
	 * Lists all invoiced customerOrder entities.
	 *
	 * @Route("/list/invoiced", name="customer_order_list_invoiced")
	 * @Method({"GET", "POST"})
	 */
	public function listInvoicedAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_INVOICED);

		return $this->render('customerorder/list_invoiced.html.twig', [
			'customerOrders' => $customerOrders,
		]);
	}

	/**
	 * Lists all paid customerOrder entities.
	 *
	 * @Route("/list/paid", name="customer_order_list_paid")
	 * @Method({"GET", "POST"})
	 */
	public function listPaidAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByStatus(CustomerOrder::STATUS_PAID);

		return $this->render('customerorder/list_paid.html.twig', [
			'customerOrders' => $customerOrders,
		]);
	}

    /**
     * Lists all customerOrder entities for the given customer.
	 *
	 * @Route("/customer/{customer_id}", name="customer_list_customer_orders")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
	 */
    public function listByCustomerAction(Request $request, Customer $customer)
    {
        $em = $this->getDoctrine()->getManager();

        $customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByCustomer($customer);

		return $this->render('customerorder/list_all.html.twig', [
			'customer' => $customer,
            'customerOrders' => $customerOrders,
        ]);
    }

    /**
     * Creates a new booked customerOrder entity.
     *
     * @Route("/customer/{customer_id}/new", name="customer_order_new")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Customer $customer)
    {
        $customerOrder = new CustomerOrder();

		$customerOrder->setCustomer($customer);

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderStatusBookedType::class, $customerOrder, ['validation_groups' => ['StatusBooked']]);

		$form->add('customer', HiddenEntityType::class, ['class' => Customer::class, 'data' => $customer]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customerOrder);
            $em->flush($customerOrder);

			if ($form->isSubmitted() && $form->isValid()) {

				$customerOrder->setStatus(CustomerOrder::STATUS_BOOKED);

				$this->getDoctrine()->getManager()->flush();

				if ($request->request->get('customerOrder_status_inprogress')) {
					return $this->redirectToRoute('customer_order_edit_inprogress', ['id' => $customerOrder->getId()]);
				} else {
					if ($request->request->get('customerOrder_status_complete')) {
						return $this->redirectToRoute('customer_order_edit_complete', ['id' => $customerOrder->getId()]);
					}
				}

				return $this->redirectToRoute('show_customer_order', ['id' => $customerOrder->getId()]);
			}
		}

        return $this->render('customerorder/new.html.twig', array(
            'customerOrder' => $customerOrder,
            'form' => $form->createView(),
        ));
    }


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
	 * Finds and emails an invoiced customerOrder entity.
	 *
	 * @Route("/{id}/send/invoice", name="send_invoice_customer_order")
	 * @Method("GET")
	 */
	public function sendEmailInvoiceAction(CustomerOrder $customerOrder)
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

		$this->get('mailer')->send($message);

		return $this->render(
			'customerorder/email_invoice.html.twig',
			[
				'customerOrder' => $customerOrder,
			]
		);
	}


	/**
	 * Finds and displays an invoiced customerOrder entity.
	 *
	 * @Route("/{id}/show/invoice", name="show_invoice_customer_order")
	 * @Method("GET")
	 */
	public function showEmailInvoiceAction(CustomerOrder $customerOrder)
	{
		# https://github.com/commerceguys/tax/
		$taxTypeRepository = $this->getDoctrine()->getRepository('AppBundle:TaxType');

		$chainTaxTypeResolver = new ChainTaxTypeResolver();
		$chainTaxTypeResolver->addResolver(new CanadaTaxTypeResolver($taxTypeRepository));
		$chainTaxTypeResolver->addResolver(new DefaultTaxTypeResolver($taxTypeRepository));
		$chainTaxRateResolver = new ChainTaxRateResolver();
		$chainTaxRateResolver->addResolver(new DefaultTaxRateResolver());
		$resolver = new TaxResolver($chainTaxTypeResolver, $chainTaxRateResolver);

		$context = new Context($customerOrder->getCustomer()->getAddress(), $customerOrder->getCompany()->getAddress());

		$context->setDate($customerOrder->getCompletedAt());

		$amounts = $resolver->resolveAmounts($customerOrder, $context);

		// More rarely, if only the types or rates are needed:
		$rates = $resolver->resolveRates($customerOrder, $context);
		$types = $resolver->resolveTypes($customerOrder, $context);

		dump($amounts);die;

		return $this->render(
			'customerorder/email_invoice.html.twig',
			[
				'customerOrder' => $customerOrder,
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
		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderStatusBookedType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['StatusBooked']]);

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
	 * Displays a form to edit or cancel an existing customerOrder entity.
	 *
	 * @Route("/{id}/edit/inprogress", name="customer_order_edit_inprogress")
	 * @Method({"GET", "POST"})
	 */
	public function editInProgressAction(Request $request, CustomerOrder $customerOrder)
	{
		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderStatusInProgressType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['StatusInProgress']]);

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

		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderStatusCompleteType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['StatusComplete']]);

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
		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderStatusInvoicedType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['StatusInvoiced']]);

		$form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_COMPLETE, CustomerOrder::STATUS_INVOICED])) {
			$form->addError(new \Symfony\Component\Form\FormError('Cannot Invoice Order'));
		}

        if ($form->isSubmitted() && $form->isValid()) {

			$customerOrder->setStatus(CustomerOrder::STATUS_INVOICED);

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
		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderStatusPaidType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['StatusPaid']]);

		$form->handleRequest($request);

		if (!in_array($customerOrder->getStatus(), [CustomerOrder::STATUS_COMPLETE, CustomerOrder::STATUS_INVOICED, CustomerOrder::STATUS_PAID])) {
			$form->addError(new \Symfony\Component\Form\FormError('Cannot Invoice Order'));
		}

        if ($form->isSubmitted() && $form->isValid()) {

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
		$form = $this->createForm(\AppBundle\Form\Type\CustomerOrderStatusCancelledType::class, $customerOrder, ['label' => $customerOrder->getStatus(), 'validation_groups' => ['StatusCancelled']]);

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
