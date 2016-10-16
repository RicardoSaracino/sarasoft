<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomersAddresses;

use AppBundle\Form\Model\CustomerAddress;
use AppBundle\Form\CustomerAddressType;


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

        return $this->render('customer/index.html.twig', array(
            'customers' => $customers,
        ));
    }

  	/**
	 * Creates a new Customer entity.
	 *
	 * @Route("/new", name="customer_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$customerAddressModel = new CustomerAddress(new Customer(), new Address());

		$form = $this->createForm(CustomerAddressType::class, $customerAddressModel);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$customersAddresses = new CustomersAddresses();
			$customersAddresses->setCustomer($customerAddressModel->customer);
			$customersAddresses->setAddress($customerAddressModel->address);

			$em->persist($customerAddressModel->customer);
			$em->persist($customerAddressModel->address);
			$em->persist($customersAddresses);

			$em->flush();

			return $this->redirectToRoute('customer_show', array('id' => $customerAddressModel->customer->getId()));
		}

		return $this->render('customer/new.html.twig',[
			'form' => $form->createView(),
		]);
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

		$address = $customersAddresses->getAddress();

		return $this->render('customer/show.html.twig', [
            'customer_address' => new CustomerAddress($customer, $address)
        ]);
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

		$customerAddressModel = new CustomerAddress($customer,$customersAddresses->getAddress());

		$form = $this->createForm(CustomerAddressType::class, $customerAddressModel);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($customerAddressModel->customer);
			$em->persist($customerAddressModel->address);

			$em->flush();

			return $this->redirectToRoute('customer_show', array('id' => $customerAddressModel->customer->getId()));
		}

		return $this->render('customer/new.html.twig',[
				'form' => $form->createView(),
			]);
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
            ->getForm()
        ;
    }
}
