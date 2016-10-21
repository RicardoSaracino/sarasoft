<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomerOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


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
     * @Route("/", name="customerorder_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customerOrders = $em->getRepository('AppBundle:CustomerOrder')->findAll();

        return $this->render('customerorder/index.html.twig', array(
            'customerOrders' => $customerOrders,
        ));
    }

    /**
     * Creates a new customerOrder entity.
     *
     * @Route("/new/{customer_id}", name="customerorder_new")
	 *
	 * @ParamConverter("customer", options={"mapping": {"customer_id" : "id"}})
	 *
	 * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Customer $customer)
    {
        $customerOrder = new CustomerOrder();

        $form = $this->createForm('AppBundle\Form\CustomerOrderType', $customerOrder);

		$form->add('customer_id', \AppBundle\Form\Model\EntityHiddenType::class, ['data' => $customer]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customerOrder);
            $em->flush($customerOrder);

            return $this->redirectToRoute('customerorder_show', array('id' => $customerOrder->getId()));
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
     * @Route("/{id}", name="customerorder_show")
     * @Method("GET")
     */
    public function showAction(CustomerOrder $customerOrder)
    {
        $deleteForm = $this->createDeleteForm($customerOrder);

        return $this->render('customerorder/show.html.twig', array(
            'customerOrder' => $customerOrder,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing customerOrder entity.
     *
     * @Route("/{id}/edit", name="customerorder_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CustomerOrder $customerOrder)
    {
        $deleteForm = $this->createDeleteForm($customerOrder);
        $editForm = $this->createForm('AppBundle\Form\CustomerOrderType', $customerOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customerorder_edit', array('id' => $customerOrder->getId()));
        }

        return $this->render('customerorder/edit.html.twig', array(
            'customerOrder' => $customerOrder,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a customerOrder entity.
     *
     * @Route("/{id}", name="customerorder_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CustomerOrder $customerOrder)
    {
        $form = $this->createDeleteForm($customerOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customerOrder);
            $em->flush($customerOrder);
        }

        return $this->redirectToRoute('customerorder_index');
    }

    /**
     * Creates a form to delete a customerOrder entity.
     *
     * @param CustomerOrder $customerOrder The customerOrder entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CustomerOrder $customerOrder)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customerorder_delete', array('id' => $customerOrder->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
