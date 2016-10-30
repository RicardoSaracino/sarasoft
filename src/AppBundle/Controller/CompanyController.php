<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Company controller.
 *
 * @Route("company")
 */
class CompanyController extends Controller
{
	/**
	 * Lists all company entities.
	 *
	 * @Route("/", name="company_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$companies = $em->getRepository('AppBundle:Company')->findAll();

		return $this->render(
			'company/index.html.twig',
			[
				'companies' => $companies,
			]
		);
	}

	/**
	 * Creates a new company entity.
	 *
	 * @Route("/new", name="company_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$company = new Company();
		$form = $this->createForm('AppBundle\Form\Type\CompanyType', $company);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($company);
			$em->flush($company);

			return $this->redirectToRoute('company_show', ['id' => $company->getId()]);
		}

		return $this->render(
			'company/new.html.twig',
			[
				'company' => $company,
				'form' => $form->createView(),
			]
		);
	}

	/**
	 * Finds and displays a company entity.
	 *
	 * @Route("/{id}", name="company_show")
	 * @Method("GET")
	 */
	public function showAction(Company $company)
	{
		return $this->render(
			'company/show.html.twig',
			[
				'company' => $company,
			]
		);
	}

	/**
	 * Displays a form to edit an existing company entity.
	 *
	 * @Route("/{id}/edit", name="company_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Company $company)
	{
		$form = $this->createForm('AppBundle\Form\Type\CompanyType', $company);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('company_show', ['id' => $company->getId()]);
		}

		return $this->render(
			'company/edit.html.twig',
			[
				'company' => $company,
				'form' => $form->createView()
			]
		);
	}
}
