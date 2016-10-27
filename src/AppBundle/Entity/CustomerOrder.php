<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * CustomerOrders
 *
 * @ORM\Table(name="customer_order", indexes={@ORM\Index(name="customer_id", columns={"customer_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class CustomerOrder
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \AppBundle\Entity\Customer
	 *
	 * @ORM\ManyToOne(targetEntity="Customer")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
	 * })
	 */
	private $customer;

	/**
	 * @var \AppBundle\Entity\Referral
	 *
	 * @ORM\ManyToOne(targetEntity="Referral")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="referral_id", referencedColumnName="id")
	 * })
	 */
	private $referral;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="order_status_code", type="string", length=3, nullable=false)
	 */
	private $orderStatusCode = 'BKD';

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_from", type="date", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $bookedFrom;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_until", type="date", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $bookedUntil;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="started_on", type="date", nullable=true)
	 */
	private $startedOn;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="finished_on", type="date", nullable=true)
	 */
	private $finishedOn;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="paid_on", type="date", nullable=true)
	 */
	private $paidOn;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="details", type="text", length=65535, nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $details;

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
	 * @ORM\ManyToOne(targetEntity="User")
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
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
	 * })
	 *
	 * @Gedmo\Blameable(on="update")
	 */
	private $updatedBy;

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
	 * Set customer
	 *
	 * @param \AppBundle\Entity\Customer $customer
	 *
	 * @return CustomerOrder
	 */
	public function setCustomer(\AppBundle\Entity\Customer $customer = null)
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
	 * Set referral
	 *
	 * @param \AppBundle\Entity\Referral $referral
	 *
	 * @return CustomerOrder
	 */
	public function setReferral(\AppBundle\Entity\Referral $referral = null)
	{
		$this->referral = $referral;

		return $this;
	}

	/**
	 * Get referral
	 *
	 * @return \AppBundle\Entity\Referral
	 */
	public function getReferral()
	{
		return $this->referral;
	}

	/**
	 * @param $orderStatusCode
	 * @return $this
	 */
	public function setOrderStatusCode($orderStatusCode)
	{
		$this->orderStatusCode = $orderStatusCode;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOrderStatusCode()
	{
		return $this->orderStatusCode;
	}


	/**
	 * @param $bookedFrom
	 * @return $this
	 */
	public function setBookedFrom($bookedFrom)
	{
		$this->bookedFrom = $bookedFrom;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getBookedFrom()
	{
		return $this->bookedFrom;
	}

	/**
	 * @param $bookedUntil
	 * @return $this
	 */
	public function setBookedUntil($bookedUntil)
	{
		$this->bookedUntil = $bookedUntil;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getBookedUntil()
	{
		return $this->bookedUntil;
	}


	/**
	 * @param $startedOn
	 * @return $this
	 */
	public function setStartedOn($startedOn)
	{
		$this->startedOn = $startedOn;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getStartedOn()
	{
		return $this->startedOn;
	}

	/**
	 * @param $finishedOn
	 * @return $this
	 */
	public function setFinishedOn($finishedOn)
	{
		$this->finishedOn = $finishedOn;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getFinishedOn()
	{
		return $this->finishedOn;
	}

	/**
	 * @param $paidOn
	 * @return $this
	 */
	public function setPaidOn($paidOn)
	{
		$this->paidOn = $paidOn;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getPaidOn()
	{
		return $this->paidOn;
	}

	/**
	 * @param $details
	 * @return $this
	 */
	public function setDetails($details)
	{
		$this->details = $details;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDetails()
	{
		return $this->details;
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
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @return \AppBundle\Entity\User
	 */
	public function getUpdatedBy()
	{
		return $this->updatedBy;
	}


	/**
	 * @return \AppBundle\Entity\User
	 */
	public function getCreatedBy()
	{
		return $this->createdBy;
	}
}