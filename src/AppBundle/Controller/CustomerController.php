<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomersAddresses;
use AppBundle\Form\CustomerAddressType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



/**
 * Customer controller.
 *
 * @Route("/customer")
 */
class CustomerController extends Controller
{
	/**
	 * Lists all Customer entities.
	 *
	 * @Route("/", name="customer_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$customers = $em->getRepository('AppBundle:Customer')->findAll();

		return $this->render(
			'customer/index.html.twig',
			[
				'customers' => $customers
			]
		);
	}

	/**
	 * Creates a new Customer entity.
	 *
	 * @Route("/new", name="customer_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$customersAddresses = new CustomersAddresses();

		$form = $this->createForm(CustomerAddressType::class, $customersAddresses);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($customersAddresses);

			$em->flush();

			return $this->redirectToRoute('customer_show', array('id' => $customersAddresses->getCustomer()->getId()));
		}

		return $this->render(
			'customer/new.html.twig',
			[
				'form' => $form->createView(),
			]
		);
	}

	/**
	 * Finds and displays a Customer entity.
	 *
	 * @Route("/{id}", name="customer_show")
	 * @Method("GET")
	 */
	public function showAction(Customer $customer)
	{
		$em = $this->getDoctrine()->getManager();

		$customersAddresses = $em->getRepository(CustomersAddresses::class)->findOneBy(['customer' => $customer]);

		return $this->render(
			'customer/show.html.twig',
			[
				'customer_address' => $customersAddresses
			]
		);
	}

	/**
	 * Displays a form to edit an existing Customer entity.
	 *
	 * @Route("/{id}/edit", name="customer_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Customer $customer)
	{
		$em = $this->getDoctrine()->getManager();

		$customersAddresses = $em->getRepository(CustomersAddresses::class)->findOneBy(['customer' => $customer]);

		$form = $this->createForm(CustomerAddressType::class, $customersAddresses);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($customersAddresses);

			$em->flush();

			return $this->redirectToRoute('customer_show', array('id' => $customersAddresses->getCustomer()->getId()));
		}

		return $this->render(
			'customer/edit.html.twig',
			[
				'form' => $form->createView(),
			]
		);
    }

	/**
	 * Deletes a Customer entity.
	 *
	 * @Route("/{id}", name="customer_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, Customer $customer)
	{
		$form = $this->createDeleteForm($customer);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($customer);
			$em->flush();
		}

		return $this->redirectToRoute('customer_index');
	}

	/**
	 * Creates a form to delete a Customer entity.
	 *
	 * @param Customer $customer The Customer entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Customer $customer)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('customer_delete', array('id' => $customer->getId())))
			->setMethod('DELETE')
			->getForm();
	}
}
