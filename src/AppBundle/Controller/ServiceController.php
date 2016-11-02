<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Service controller.
 *
 * @Route("service")
 */
class ServiceController extends Controller
{
	/**
	 * Lists all service entities.
	 *
	 * @Route("/", name="service_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$services = $em->getRepository('AppBundle:Service')->findAll();

		return $this->render(
			'service/index.html.twig',
			[
				'services' => $services,
			]
		);
	}

	/**
	 * Creates a new service entity.
	 *
	 * @Route("/new", name="service_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$service = new Service();
		$form = $this->createForm('AppBundle\Form\Type\ServiceType', $service);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($service);
			$em->flush($service);

			return $this->redirectToRoute('service_show', array('id' => $service->getId()));
		}

		return $this->render(
			'service/new.html.twig',
			[
				'service' => $service,
				'form' => $form->createView(),
			]
		);
	}

	/**
	 * Finds and displays a service entity.
	 *
	 * @Route("/{id}", name="service_show")
	 * @Method("GET")
	 */
	public function showAction(Service $service)
	{
		return $this->render(
			'service/show.html.twig',
			[
				'service' => $service
			]
		);
	}

	/**
	 * Displays a form to edit an existing service entity.
	 *
	 * @Route("/{id}/edit", name="service_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Service $service)
	{
		$form = $this->createForm('AppBundle\Form\Type\ServiceType', $service);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('service_show', array('id' => $service->getId()));
		}

		return $this->render(
			'service/edit.html.twig',
			[
				'service' => $service,
				'form' => $form->createView(),
			]
		);
	}
}