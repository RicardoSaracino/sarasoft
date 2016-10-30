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
     * @var \Address
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Company
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set altPhone
     *
     * @param string $altPhone
     *
     * @return Company
     */
    public function setAltPhone($altPhone)
    {
        $this->altPhone = $altPhone;

        return $this;
    }

    /**
     * Get altPhone
     *
     * @return string
     */
    public function getAltPhone()
    {
        return $this->altPhone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Company
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

	/**
	 * Set address
	 *
	 * @param \AppBundle\Entity\Address $address
	 *
	 * @return Company
	 */
	public function setAddress(\AppBundle\Entity\Address $address = null)
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
