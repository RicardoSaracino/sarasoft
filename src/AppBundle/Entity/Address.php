<?php

namespace AppBundle\Entity;

use AppBundle\Util\StateProvince;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Address
 *
 * @ORM\Table(name="address", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class Address
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="line_1", type="string", length=32, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Length(min=3)
	 */
	private $line1;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="line_2", type="string", length=32, nullable=true)
	 */
	private $line2;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="line_3", type="string", length=32, nullable=true)
	 */
	private $line3;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="city", type="string", length=32, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Length(min=3)
	 */
	private $city;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="zip_or_postalcode", type="string", length=32, nullable=false)
	 *
	 * todo validate with county
	 */
	private $zipOrPostalcode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="state_or_province", type="string", length=32, nullable=false)
	 *
	 * todo validate with county
	 */
	private $stateOrProvince;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="country", type="string", length=6, nullable=false)
	 *
	 * @Assert\Country()
	 */
	private $country;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 *
	 * @Gedmo\Timestampable(on="create")
	 */
	private $createdAt;

	/**
	 * @var \AppBundle\Entity\User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
	 * })
	 *
	 * @Gedmo\Blameable(on="create")
	 */
	private $createdBy;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 *
	 * @Gedmo\Timestampable(on="update")
	 */
	private $updatedAt;

	/**
	 * @var \AppBundle\Entity\User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
	 * })
	 *
	 * @Gedmo\Blameable(on="update")
	 */
	private $updatedBy;

	/**
	 * @return bool
	 *
	 * @Assert\IsTrue(message="The state or province does not match country")
	 */
	public function isStateOrProvinceValid()
	{
		if ($this->getCountry() == 'CA') {

			return array_key_exists($this->getStateOrProvince(), StateProvince::getProvinces());
		} else {
			if ($this->getCountry() == 'US') {

				return array_key_exists($this->getStateOrProvince(), StateProvince::getStates());
			}
		}

		return true;
	}

	/**
	 * @return bool
	 *
	 * @Assert\IsTrue(message="The zip or postal code does not match country")
	 */
	public function isZipOrPostalcodeValid()
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

		if (array_key_exists($this->getCountry(), $ZIPREG)) {
			$reg = $ZIPREG[$this->getCountry()];
			return 1 === preg_match('/' . $reg . '/i', $this->getZipOrPostalcode());
		}

		return true;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set line1
	 *
	 * @param string $line1
	 *
	 * @return Address
	 */
	public function setLine1($line1)
	{
		$this->line1 = $line1;

		return $this;
	}

	/**
	 * Get line1
	 *
	 * @return string
	 */
	public function getLine1()
	{
		return $this->line1;
	}

	/**
	 * Set line2
	 *
	 * @param string $line2
	 *
	 * @return Address
	 */
	public function setLine2($line2)
	{
		$this->line2 = $line2;

		return $this;
	}

	/**
	 * Get line2
	 *
	 * @return string
	 */
	public function getLine2()
	{
		return $this->line2;
	}

	/**
	 * Set line3
	 *
	 * @param string $line3
	 *
	 * @return Address
	 */
	public function setLine3($line3)
	{
		$this->line3 = $line3;

		return $this;
	}

	/**
	 * Get line3
	 *
	 * @return string
	 */
	public function getLine3()
	{
		return $this->line3;
	}

	/**
	 * Set city
	 *
	 * @param string $city
	 *
	 * @return Address
	 */
	public function setCity($city)
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * Get city
	 *
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * Set zipOrPostalcode
	 *
	 * Upper case on set
	 *
	 * @param string $zipOrPostalcode
	 *
	 * @return Address
	 */
	public function setZipOrPostalcode($zipOrPostalcode)
	{
		$this->zipOrPostalcode = mb_strtoupper($zipOrPostalcode);

		return $this;
	}

	/**
	 * Get zipOrPostalcode
	 *
	 * @return string
	 */
	public function getZipOrPostalcode()
	{
		return $this->zipOrPostalcode;
	}

	/**
	 * Set stateOrProvince
	 *
	 * @param string $stateOrProvince
	 *
	 * @return Address
	 */
	public function setStateOrProvince($stateOrProvince)
	{
		$this->stateOrProvince = $stateOrProvince;

		return $this;
	}

	/**
	 * Get stateOrProvince
	 *
	 * @return string
	 */
	public function getStateOrProvince()
	{
		return $this->stateOrProvince;
	}

	/**
	 * Set country
	 *
	 * @param string $country
	 *
	 * @return Address
	 */
	public function setCountry($country)
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * Get country
	 *
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * Get createdBy
	 *
	 * @return \AppBundle\Entity\User
	 */
	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	/**
	 * Get updatedAt
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * Get updatedBy
	 *
	 * @return \AppBundle\Entity\User
	 */
	public function getUpdatedBy()
	{
		return $this->updatedBy;
	}
}