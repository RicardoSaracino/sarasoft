<?php
/**
 * @author Ricardo Saracino
 * @since 10/15/16
 */

namespace AppBundle\Form\Model;

/**
 * Class CustomerAddress
 * @package AppBundle\Form\Model
 */
class CustomerAddress {

	/**
	 * @var \AppBundle\Entity\Customer
	 */
	public $customer;

	/**
	 * @var \AppBundle\Entity\Address
	 */
	public $address;

	/**
	 * @param \AppBundle\Entity\Customer $customer
	 * @param \AppBundle\Entity\Address $address
	 */
	public function __construct(\AppBundle\Entity\Customer $customer, \AppBundle\Entity\Address $address)
	{
		$this->customer = $customer;
		$this->address = $address;
	}
}