<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CommerceGuys\Addressing\Model\AddressInterface;
use CommerceGuys\Zone\Model\ZoneEntityInterface;
use CommerceGuys\Zone\Model\ZoneMemberEntityInterface;
use CommerceGuys\Zone\PostalCodeHelper;

/**
 * ZoneMemberCountry
 *
 * @ORM\Table(name="zone_member_country", uniqueConstraints={@ORM\UniqueConstraint(name="zone_id_3", columns={"zone_id", "country_code", "adminnistrative_area", "locality", "dependent_locality"})}, indexes={@ORM\Index(name="zone_id", columns={"zone_id"}), @ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="zone_id_2", columns={"zone_id"}), @ORM\Index(name="created_at", columns={"created_at"}), @ORM\Index(name="created_at_2", columns={"created_at"})})
 * @ORM\Entity
 */
class ZoneMemberCountry implements ZoneMemberEntityInterface
{
	use Traits\Timestampable;
	use Traits\Blameable;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \Zone
	 *
	 * @ORM\ManyToOne(targetEntity="Zone", inversedBy="members")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
	 * })
	 */
	private $zone;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=64, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="country_code", type="string", length=8, nullable=false)
	 */
	private $countryCode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="administrative_area", type="string", length=64, nullable=false)
	 */
	private $administrativeArea;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="locality", type="string", length=64, nullable=true)
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
	 * @ORM\Column(name="included_postal_codes", type="string", length=256, nullable=true)
	 */
	private $includedPostalCodes;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="excluded_postal_codes", type="string", length=256, nullable=true)
	 */
	private $excludedPostalCodes;

	/**
	 * @return int|string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 * @return $this|ZoneMemberEntityInterface
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return $this|ZoneMemberEntityInterface
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return \CommerceGuys\Zone\Model\ZoneInterface|null
	 */
	public function getParentZone()
	{
		return $this->parentZone;
	}

	/**
	 * @param ZoneEntityInterface $zone
	 * @return $this|ZoneMemberEntityInterface
	 */
	public function setParentZone(ZoneEntityInterface $zone = null)
	{
		$this->zone = $zone;

		return $this;
	}

	/**
	 * @return string
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
	 * @return string
	 */
	public function getAdministrativeArea()
	{
		return $this->administrativeArea;
	}

	/**
	 * @param null $administrativeArea
	 * @return $this
	 */
	public function setAdministrativeArea($administrativeArea = null)
	{
		$this->administrativeArea = $administrativeArea;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLocality()
	{
		return $this->locality;
	}

	/**
	 * @param null $locality
	 * @return $this
	 */
	public function setLocality($locality = null)
	{
		$this->locality = $locality;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDependentLocality()
	{
		return $this->dependentLocality;
	}

	/**
	 * @param null $dependentLocality
	 * @return $this
	 */
	public function setDependentLocality($dependentLocality = null)
	{
		$this->dependentLocality = $dependentLocality;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIncludedPostalCodes()
	{
		return $this->includedPostalCodes;
	}

	/**
	 * @param $includedPostalCodes
	 * @return $this
	 */
	public function setIncludedPostalCodes($includedPostalCodes)
	{
		$this->includedPostalCodes = $includedPostalCodes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getExcludedPostalCodes()
	{
		return $this->excludedPostalCodes;
	}

	/**
	 * @param $excludedPostalCodes
	 * @return $this
	 */
	public function setExcludedPostalCodes($excludedPostalCodes)
	{
		$this->excludedPostalCodes = $excludedPostalCodes;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function match(AddressInterface $address)
	{
		if ($address->getCountryCode() != $this->countryCode) {
			return false;
		}
		if ($this->administrativeArea && $this->administrativeArea != $address->getAdministrativeArea()) {
			return false;
		}
		if ($this->locality && $this->locality != $address->getLocality()) {
			return false;
		}
		if ($this->dependentLocality && $this->dependentLocality != $address->getDependentLocality()) {
			return false;
		}
		if (!PostalCodeHelper::match($address->getPostalCode(), $this->includedPostalCodes, $this->excludedPostalCodes)) {
			return false;
		}

		return true;
	}
}