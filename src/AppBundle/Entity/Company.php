<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * Company
 *
 * @ORM\Table(name="company", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="address_id", columns={"address_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class Company
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
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Length(min=3)
	 */
    private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="phone", type="phone_number", length=35, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @AssertPhoneNumber
	 */
	private $phone;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="alt_phone", type="phone_number", length=35, nullable=true)
	 *
	 * @AssertPhoneNumber
	 */
	private $altPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="website_url", type="string", length=256, nullable=true)
	 *
	 * @Assert\Url()
     */
    private $websiteUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_url", type="string", length=256, nullable=true)
	 *
	 * @Assert\Url()
     */
    private $facebookUrl;

    /**
     * @var \AppBundle\Entity\Address
     *
     * @ORM\ManyToOne(targetEntity="Address", cascade={"all"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * })
	 *
	 * @Assert\Valid()
     */
    private $address;

	/**
	 * @return int
	 */
	public function getId()
    {
        return $this->id;
    }

	/**
	 * @param $name
	 * @return $this
	 */
	public function setName($name)
    {
        $this->name = $name;

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
	 * @param $phone
	 * @return $this
	 */
	public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

	/**
	 * @param $altPhone
	 * @return $this
	 */
	public function setAltPhone($altPhone)
    {
        $this->altPhone = $altPhone;

        return $this;
    }

    /**
     * @return string
     */
    public function getAltPhone()
    {
        return $this->altPhone;
    }

	/**
	 * @param $email
	 * @return $this
	 */
	public function setEmail($email)
    {
		$this->email = mb_strtolower($email);

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

	/**
	 * @param $websiteUrl
	 * @return $this
	 */
	public function setWebsiteUrl($websiteUrl)
    {
		$this->websiteUrl = mb_strtolower($websiteUrl);

        return $this;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

	/**
	 * @param $facebookUrl
	 * @return $this
	 */
	public function setFacebookUrl($facebookUrl)
    {
		$this->facebookUrl = mb_strtolower($facebookUrl);

        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookUrl()
    {
        return $this->facebookUrl;
    }

	/**
	 * @param Address $address
	 * @return $this
	 */
	public function setAddress(\AppBundle\Entity\Address $address = null)
	{
		$this->address = $address;

		return $this;
	}

	/**
	 * @return Address
	 */
	public function getAddress()
	{
		return $this->address;
	}
}
