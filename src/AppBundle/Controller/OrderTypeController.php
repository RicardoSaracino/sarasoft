<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Refferal controller.
 *
 * @Route("/ordertype")
 */
class OrderTypeController extends Controller
{
	/**
	 * Lists all order type entities.
	 *
	 * @Route("/", name="order_type_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$orderTypes = $em->getRepository('AppBundle:OrderType')->findAll();

		return $this->render(
			'ordertype/index.html.twig',
			[
				'orderTypes' => $orderTypes,
			]
		);
	}

	/**
	 * Creates a new order type entity.
	 *
	 * @Route("/new", name="order_type_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$orderType = new OrderType();
		$form = $this->createForm('AppBundle\Form\Type\OrderTypeType', $orderType);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($orderType);
			$em->flush($orderType);

			return $this->redirectToRoute('order_type_show', array('id' => $orderType->getId()));
		}

		return $this->render(
			'ordertype/new.html.twig',
			[
				'orderType' => $orderType,
				'form' => $form->createView(),
			]
		);
	}

	/**
	 * Finds and displays a order type entity.
	 *
	 * @Route("/{id}", name="order_type_show")
	 * @Method("GET")
	 */
	public function showAction(OrderType $orderType)
	{
		return $this->render(
			'ordertype/show.html.twig',
			[
				'orderType' => $orderType,
			]
		);
	}

	/**
	 * Displays a form to edit an existing order type entity.
	 *
	 * @Route("/{id}/edit", name="order_type_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, OrderType $orderType)
	{
		$form = $this->createForm('AppBundle\Form\Type\OrderTypeType', $orderType);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('order_type_show', array('id' => $orderType->getId()));
		}

		return $this->render(
			'ordertype/edit.html.twig',
			[
				'orderType' => $orderType,
				'form' => $form->createView(),
			]
		);
	}
}