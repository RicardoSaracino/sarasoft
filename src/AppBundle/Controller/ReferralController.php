<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Referral;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Customerorderreferral controller.
 *
 * @Route("referral")
 */
class ReferralController extends Controller
{
	/**
	 * Lists all referral entities.
	 *
	 * @Route("/", name="referral_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$referrals = $em->getRepository('AppBundle:Referral')->findAll();

		return $this->render(
			'referral/index.html.twig',
			array(
				'referrals' => $referrals,
			)
		);
	}

	/**
	 * Creates a new referral entity.
	 *
	 * @Route("/new", name="referral_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$referral = new Referral();
		$form = $this->createForm('AppBundle\Form\Type\ReferralType', $referral);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($referral);
			$em->flush($referral);

			return $this->redirectToRoute('referral_show', array('id' => $referral->getId()));
		}

		return $this->render(
			'referral/new.html.twig',
			array(
				'referral' => $referral,
				'form' => $form->createView(),
			)
		);
	}

	/**
	 * Finds and displays a referral entity.
	 *
	 * @Route("/{id}", name="referral_show")
	 * @Method("GET")
	 */
	public function showAction(Referral $referral)
	{
		$deleteForm = $this->createDeleteForm($referral);

		return $this->render(
			'referral/show.html.twig',
			array(
				'referral' => $referral,
				'delete_form' => $deleteForm->createView(),
			)
		);
	}

	/**
	 * Displays a form to edit an existing referral entity.
	 *
	 * @Route("/{id}/edit", name="referral_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Referral $referral)
	{
		$form = $this->createForm('AppBundle\Form\Type\ReferralType', $referral);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('referral_show', array('id' => $referral->getId()));
		}

		return $this->render(
			'referral/edit.html.twig',
			array(
				'referral' => $referral,
				'form' => $form->createView(),
			)
		);
	}

	/**
	 * Deletes a referral entity.
	 *
	 * @Route("/{id}", name="referral_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, Referral $referral)
	{
		$form = $this->createDeleteForm($referral);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($referral);
			$em->flush($referral);
		}

		return $this->redirectToRoute('referral_index');
	}

	/**
	 * Creates a form to delete a referral entity.
	 *
	 * @param Referral $referral The referral entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Referral $referral)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('referral_delete', array('id' => $referral->getId())))
			->setMethod('DELETE')
			->getForm();
	}
}
