<?php
/**
 * @author Ricardo Saracino
 * @since 10/15/16
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CustomerAddress
 *
 * @see http://symfony.com/doc/current/reference/constraints/Valid.html
 *
 * @package AppBundle\Form\Model
 */
class CustomerAddress
{
	/**
	 * @var \AppBundle\Entity\Customer
	 *
	 * @Assert\Valid()
	 */
	public $customer;

	/**
	 * @var \AppBundle\Entity\Address
	 *
	 * @Assert\Valid()
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