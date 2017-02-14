<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use AppBundle\Entity\ServicePrice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Service controller.
 *
 * @Route("service")
 * @Security("has_role('ROLE_ADMIN')")
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

		$service->addServicePrice(new ServicePrice());

		$form = $this->createForm('AppBundle\Form\Type\ServiceNewType', $service);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($service);
			$em->flush($service);

			return $this->redirectToRoute('service_show', ['id' => $service->getId()]);
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
		$form = $this->createForm('AppBundle\Form\Type\ServiceEditType', $service);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			if ($request->request->get('addServicePrice')) {
				return $this->redirectToRoute('service_price_add', ['id' => $service->getId()]);
			}

			return $this->redirectToRoute('service_show', ['id' => $service->getId()]);
		}

		return $this->render(
			'service/edit.html.twig',
			[
				'service' => $service,
				'form' => $form->createView(),
			]
		);
	}


	/**
	 * Displays a form to add a service price to an existing service entity.
	 *
	 * @Route("/{id}/new/price", name="service_price_add")
	 * @Method({"GET", "POST"})
	 */
	public function addServicePriceAction(Request $request, Service $service)
	{
		$servicePrice = new ServicePrice;

		$servicePrice->setService($service);

		$form = $this->createForm('AppBundle\Form\Type\ServicePriceType', $servicePrice);

		$form->add('service', \AppBundle\Form\Type\HiddenEntityType::class, ['class' => Service::class, 'data' => $service]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($servicePrice);
			$em->flush($servicePrice);

			return $this->redirectToRoute('service_show', ['id' => $servicePrice->getService()->getId()]);
		}

		return $this->render(
			'service/add_service_price.html.twig',
			[
				'servicePrice' => $servicePrice,
				'form' => $form->createView(),
			]
		);
	}
}