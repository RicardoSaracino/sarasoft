<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Twig;

use AppBundle\Entity\CustomerOrder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class CustomerOrderRoutingExtension
 * @package AppBundle\Twig
 */
class CustomerOrderRoutingExtension extends \Twig_Extension
{
	private $generator;

	/**
	 * @param UrlGeneratorInterface $generator
	 */
	public function __construct(UrlGeneratorInterface $generator)
	{
		$this->generator = $generator;
	}

	/**
	 * Returns a list of functions to add to the existing list.
	 *
	 * @return array An array of functions
	 */
	public function getFunctions()
	{
		# /vendor/symfony/symfony/src/Symfony/Bridge/Twig/Extension/RoutingExtension.php

		return array(
			new \Twig_SimpleFunction('customer_order_path', array($this, 'getCustomerOrderPath')),
		);
	}

	/**
	 * @param CustomerOrder $customerOrder
	 * @return string
	 */
	public function getCustomerOrderPath(CustomerOrder $customerOrder)
	{
		switch ($customerOrder->getStatus()) {
			case CustomerOrder::STATUS_BOOKED:
				return $this->generator->generate('edit_customer_order_booked', ['id' => $customerOrder->getId()]);
			case CustomerOrder::STATUS_INPROGRESS:
				return $this->generator->generate('edit_customer_order_inprogress', ['id' => $customerOrder->getId()]);
			case CustomerOrder::STATUS_COMPLETE:
				return $this->generator->generate('edit_customer_order_complete', ['id' => $customerOrder->getId()]);
			case CustomerOrder::STATUS_INVOICED:
				return $this->generator->generate('edit_customer_order_invoice', ['id' => $customerOrder->getId()]);
			case CustomerOrder::STATUS_PAID:
				return $this->generator->generate('edit_customer_order_paid', ['id' => $customerOrder->getId()]);
			case CustomerOrder::STATUS_CANCELLED:
				return $this->generator->generate('edit_customer_order_cancelled', ['id' => $customerOrder->getId()]);
		}
	}
}