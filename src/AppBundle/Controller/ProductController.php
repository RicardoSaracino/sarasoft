<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
	/**
	 * Lists all product entities.
	 *
	 * @Route("/", name="product_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$products = $em->getRepository('AppBundle:Product')->findAll();

		return $this->render(
			'product/index.html.twig',
			[
				'products' => $products,
			]
		);
	}

	/**
	 * Creates a new product entity.
	 *
	 * @Route("/new", name="product_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$product = new Product();
		$form = $this->createForm('AppBundle\Form\Type\ProductType', $product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush($product);

			return $this->redirectToRoute('product_show', array('id' => $product->getId()));
		}

		return $this->render(
			'product/new.html.twig',
			[
				'product' => $product,
				'form' => $form->createView(),
			]
		);
	}

	/**
	 * Finds and displays a product entity.
	 *
	 * @Route("/{id}", name="product_show")
	 * @Method("GET")
	 */
	public function showAction(Product $product)
	{
		return $this->render(
			'product/show.html.twig',
			[
				'product' => $product
			]
		);
	}

	/**
	 * Displays a form to edit an existing product entity.
	 *
	 * @Route("/{id}/edit", name="product_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Product $product)
	{
		$form = $this->createForm('AppBundle\Form\Type\ProductType', $product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('product_show', array('id' => $product->getId()));
		}

		return $this->render(
			'product/edit.html.twig',
			[
				'product' => $product,
				'form' => $form->createView(),
			]
		);
	}
}