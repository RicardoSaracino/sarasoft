<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CustomersAddresses
 *
 * @ORM\Table(name="customers_addresses", indexes={@ORM\Index(name="address_id", columns={"address_id"}), @ORM\Index(name="customer_id", columns={"customer_id"})})
 * @ORM\Entity
 */
class CustomersAddresses
{
	/**
	 * @var \AppBundle\Entity\Customer
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Customer", cascade={"persist"})
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
	 * })
	 *
	 * @Assert\Valid()
	 */
	private $customer;

	/**
	 * @var \AppBundle\Entity\Address
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address", cascade={"persist"})
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
	 * })
	 *
	 * @Assert\Valid()
	 */
	private $address;

	/**
	 * Set customer
	 *
	 * @param \AppBundle\Entity\Customer $customer
	 *
	 * @return CustomersAddresses
	 */
	public function setCustomer(\AppBundle\Entity\Customer $customer)
	{
		$this->customer = $customer;

		return $this;
	}

	/**
	 * Get customer
	 *
	 * @return \AppBundle\Entity\Customer
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

	/**
	 * Set address
	 *
	 * @param \AppBundle\Entity\Address $address
	 *
	 * @return CustomersAddresses
	 */
	public function setAddress(\AppBundle\Entity\Address $address)
	{
		$this->address = $address;

		return $this;
	}

	/**
	 * Get address
	 *
	 * @return \AppBundle\Entity\Address
	 */
	public function getAddress()
	{
		return $this->address;
	}
}