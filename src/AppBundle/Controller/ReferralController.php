<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Referral;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Referral controller.
 *
 * @Route("/referral")
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
			[
				'referrals' => $referrals,
			]
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
			[
				'referral' => $referral,
				'form' => $form->createView(),
			]
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
		return $this->render(
			'referral/show.html.twig',
			[
				'referral' => $referral,
			]
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
			[
				'referral' => $referral,
				'form' => $form->createView(),
			]
		);
	}
}