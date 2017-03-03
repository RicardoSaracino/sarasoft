<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CommerceGuys\Addressing\Validator\Constraints as AddressAssert;
use CommerceGuys\Addressing\Model\AddressInterface;
use AppBundle\Validator\Constraints\Subdivision as SubdivisionAssert;
use AppBundle\Validator\Constraints\PostalCode as PostalCodeAssert;

/**
 * Address
 *
 * @ORM\Table(name="address", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 *
 * @see https://github.com/commerceguys/addressing
 */
class Address implements AddressInterface
{
	use \AppBundle\Entity\Traits\Timestampable;
	use \AppBundle\Entity\Traits\Blameable;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="country_code", type="string", length=8, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @AddressAssert\Country(message="This value is not a valid province.")
	 */
	private $countryCode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="administrative_area", type="string", length=64, nullable=true)
	 *
	 * @Assert\NotBlank()
	 * @SubdivisionAssert(message="This value is not a valid province.")
	 */
	private $administrativeArea;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="locality", type="string", length=64, nullable=true)
	 *
	 * @Assert\NotBlank()
	 */
	private $locality;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="dependent_locality", type="string", length=64, nullable=true)
	 */
	private $dependentLocality;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="postal_code", type="string", length=64, nullable=false)
	 *
	 * @PostalCodeAssert(message="This value is not a valid postal code.")
	 */
	private $postalCode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="sorting_code", type="string", length=64, nullable=true)
	 */
	private $sortingCode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="address_line_1", type="string", length=64, nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $addressLine1;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="address_line_2", type="string", length=64, nullable=true)
	 */
	private $addressLine2;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="locale", type="string", length=64, nullable=false)
	 */
	private $locale = 'und';

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCountryCode()
	{
		return $this->countryCode;
	}

	/**
	 * @param $countryCode
	 * @return $this
	 */
	public function setCountryCode($countryCode)
	{
		$this->countryCode = $countryCode;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAdministrativeArea()
	{
		return $this->administrativeArea;
	}

	/**
	 * @param $administrativeArea
	 * @return $this
	 */
	public function setAdministrativeArea($administrativeArea)
	{
		$this->administrativeArea = $administrativeArea;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLocality()
	{
		return $this->locality;
	}

	/**
	 * @param $locality
	 * @return $this
	 */
	public function setLocality($locality)
	{
		$this->locality = $locality;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDependentLocality()
	{
		return $this->dependentLocality;
	}

	/**
	 * @param $dependentLocality
	 * @return $this
	 */
	public function setDependentLocality($dependentLocality)
	{
		$this->dependentLocality = $dependentLocality;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPostalCode()
	{
		return $this->postalCode;
	}

	/**
	 * @param $postalCode
	 * @return $this
	 */
	public function setPostalCode($postalCode)
	{
		$this->postalCode = mb_strtoupper($postalCode);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSortingCode()
	{
		return $this->sortingCode;
	}

	/**
	 * @param $sortingCode
	 * @return $this
	 */
	public function setSortingCode($sortingCode)
	{
		$this->sortingCode = $sortingCode;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAddressLine1()
	{
		return $this->addressLine1;
	}

	/**
	 * @param $addressLine1
	 * @return $this
	 */
	public function setAddressLine1($addressLine1)
	{
		$this->addressLine1 = $addressLine1;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAddressLine2()
	{
		return $this->addressLine2;
	}

	/**
	 * @param $addressLine2
	 * @return $this
	 */
	public function setAddressLine2($addressLine2)
	{
		$this->addressLine2 = $addressLine2;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * @param $locale
	 * @return $this
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRecipient()
	{
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOrganization()
	{
		return '';
	}
}