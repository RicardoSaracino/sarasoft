<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductPrice;


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

		$product->addProductPrice(new ProductPrice());

		$form = $this->createForm('AppBundle\Form\Type\ProductNewType', $product);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush($product);

			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
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
		$form = $this->createForm('AppBundle\Form\Type\ProductEditType', $product);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			if ($request->request->get('addProductPrice')) {
				return $this->redirectToRoute('product_price_add', ['id' => $product->getId()]);
			}

			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
		}

		return $this->render(
			'product/edit.html.twig',
			[
				'product' => $product,
				'form' => $form->createView(),
			]
		);
	}


	/**
	 * Displays a form to add a product price to an existing product entity.
	 *
	 * @Route("/{id}/new/price", name="product_price_add")
	 * @Method({"GET", "POST"})
	 */
	public function addProductPriceAction(Request $request, Product $product)
	{
		$productPrice = new ProductPrice;

		$productPrice->setProduct($product);

		$form = $this->createForm('AppBundle\Form\Type\ProductPriceType', $productPrice);

		$form->add('product', \AppBundle\Form\Type\HiddenEntityType::class, ['class' => Product::class, 'data' => $product]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($productPrice);
			$em->flush($productPrice);

			return $this->redirectToRoute('product_show', ['id' => $productPrice->getProduct()->getId()]);
		}

		return $this->render(
			'product/add_product_price.html.twig',
			[
				'productPrice' => $productPrice,
				'form' => $form->createView(),
			]
		);
	}
}