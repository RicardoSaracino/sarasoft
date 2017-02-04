<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CommerceGuys\Addressing\Validator\Constraints as AddressAssert;

/**
 * Address
 *
 * @ORM\Table(name="address", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 *
 * AddressAssert\AddressFormat
 */
class Address implements \CommerceGuys\Addressing\Model\AddressInterface
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
	 * @AddressAssert\Country
	 */
	private $countryCode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="administrative_area", type="string", length=64, nullable=true)
	 *
	 * @Assert\NotBlank()
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
	 * @Assert\NotBlank()
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
	 * @return bool
	 *
	 * @Assert\IsTrue(message="Invalid Province")
	 */
	public function isStateOrProvinceValid()
	{
		if ($this->getCountryCode() == 'CA') {
			return array_key_exists($this->getAdministrativeArea(), \AppBundle\Util\AdministrativeArea::getProvinces());
		} else {
			if ($this->getCountryCode() == 'US') {

				return array_key_exists($this->getAdministrativeArea(), \AppBundle\Util\AdministrativeArea::getStates());
			}
		}

		return true;
	}

	/**
	 * @return bool
	 *
	 * @Assert\IsTrue(message="Invalid Postal Code")
	 */
	public function isPostalCodeValid()
	{
		## more comprehensive list http://unicode.org/cldr/trac/browser/tags/release-26-0-1/common/supplemental/postalCodeData.xml
		$ZIPREG = array(
			'US' => '^\d{5}([\-]?\d{4})?$',
			'UK' => '^(GIR|[A-Z]\d[A-Z\d]??|[A-Z]{2}\d[A-Z\d]??)[ ]??(\d[A-Z]{2})$',
			'DE' => '\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b',
			'CA' => '^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$',
			'FR' => '^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$',
			'IT' => '^(V-|I-)?[0-9]{5}$',
			'AU' => '^(0[289][0-9]{2})|([1345689][0-9]{3})|(2[0-8][0-9]{2})|(290[0-9])|(291[0-4])|(7[0-4][0-9]{2})|(7[8-9][0-9]{2})$',
			'NL' => '^[1-9][0-9]{3}\s?([a-zA-Z]{2})?$',
			'ES' => '^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$',
			'DK' => '^([D|d][K|k]( |-))?[1-9]{1}[0-9]{3}$',
			'SE' => '^(s-|S-){0,1}[0-9]{3}\s?[0-9]{2}$',
			'BE' => '^[1-9]{1}[0-9]{3}$',
			'IN' => '^\d{6}$'
		);

		if (array_key_exists($this->getCountryCode(), $ZIPREG)) {
			$reg = $ZIPREG[$this->getCountryCode()];

			return 1 === preg_match('/' . $reg . '/i', $this->getPostalCode());
		}

		return true;
	}

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