<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomerOrder;

use AppBundle\Form\Type\CustomerOrderType;
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
	 * @Route("/", name="listCustomerOrders")
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
     * Lists all customerOrder entities for the given customer.
	 *
	 * @Route("/customer/{customer_id}", name="listCustomerOrdersByCustomer")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
	 */
    public function listByCustomerAction(Request $request, Customer $customer)
    {
        $em = $this->getDoctrine()->getManager();

        $customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findByCustomer($customer);

		return $this->render('customerorder/list.html.twig', [
			'customer' => $customer,
            'customerOrders' => $customerOrders,
        ]);
    }

    /**
     * Creates a new customerOrder entity.
     *
     * @Route("/customer/{customer_id}/new", name="newCustomerOrderForCustomer")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Customer $customer)
    {
        $customerOrder = new CustomerOrder();

        $form = $this->createForm(CustomerOrderType::class, $customerOrder);

		$form->add('customer', HiddenEntityType::class, ['class' => Customer::class, 'data' => $customer]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customerOrder);
            $em->flush($customerOrder);

            return $this->redirectToRoute('showCustomerOrder', array('id' => $customerOrder->getId()));
        }

        return $this->render('customerorder/new.html.twig', array(
			'customer' => $customer,
            'customerOrder' => $customerOrder,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a customerOrder entity.
     *
     * @Route("/{id}", name="showCustomerOrder")
     * @Method("GET")
     */
    public function showAction(CustomerOrder $customerOrder)
    {
        return $this->render('customerorder/show.html.twig', array(
            'customerOrder' => $customerOrder,
        ));
    }

    /**
     * Displays a form to edit an existing customerOrder entity.
     *
     * @Route("/{id}/edit", name="editCustomerOrder")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CustomerOrder $customerOrder)
    {
        $form = $this->createForm(CustomerOrderType::class, $customerOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('showCustomerOrder', array('id' => $customerOrder->getId()));
        }

        return $this->render('customerorder/edit.html.twig', array(
			'customer' => $customerOrder->getCustomer(),
            'customerOrder' => $customerOrder,
            'form' => $form->createView()
        ));
	}
}
