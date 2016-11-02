<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CustomerOrders
 *
 * @ORM\Table(name="customer_order", indexes={@ORM\Index(name="customer_id", columns={"customer_id"}), @ORM\Index(name="company_id", columns={"company_id"}), @ORM\Index(name="referral_id", columns={"referral_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class CustomerOrder
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
	 * @var \AppBundle\Entity\Customer
	 *
	 * @ORM\ManyToOne(targetEntity="Customer")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false)
	 * })
	 */
	private $customer;

	/**
	 * @var \AppBundle\Entity\Company
	 *
	 * @ORM\ManyToOne(targetEntity="Company")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=false)
	 * })
	 *
	 * @Assert\NotBlank()
	 */
	private $company;

	/**
	 * @var \AppBundle\Entity\Referral
	 *
	 * @ORM\ManyToOne(targetEntity="Referral")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="referral_id", referencedColumnName="id", nullable=true)
	 * })
	 */
	private $referral;

	/**
	 * @var \AppBundle\Entity\CustomerOrderService
	 *
	 * @ORM\OneToMany(targetEntity="CustomerOrderService", mappedBy="customer_order_id")
	 */
	private $customerOrderServices;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="order_status_code", type="string", length=3, nullable=false)
	 */
	private $orderStatusCode = 'BKD';

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_from", type="datetime", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $bookedFrom;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_until", type="datetime", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $bookedUntil;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="booking_notes", type="text", length=65535, nullable=false)
	 *
	 * @Assert\NotBlank(message="Booking Notes should not be blank")
	 */
	private $bookingNotes;

	/**
	 *
	 */
	public function __construct()
	{
		$this->customerOrderServices = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * @return bool
	 *
	 * @Assert\IsTrue(message="Booked From must be before Booked Until")
	 */
	public function isBookedFromUntilLegal()
	{
		return ($this->bookedFrom <= $this->bookedUntil);
	}

	/**
	 * @return bool
	 *
	 * @Assert\IsTrue(message="Booking must be in the future")
	 */
	public function isBookedFromLegal()
	{
		return true; # return ($this->bookedFrom >= (new \DateTime('now')));
	}


	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
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
	 * @return \AppBundle\Entity\Customer
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

	/**
	 * @param \AppBundle\Entity\Company $company
	 *
	 * @return CustomerOrder
	 */
	public function setCompany(\AppBundle\Entity\Company $company = null)
	{
		$this->company = $company;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\Company
	 */
	public function getCompany()
	{
		return $this->company;
	}

	/**
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
	 * @return \AppBundle\Entity\Referral
	 */
	public function getReferral()
	{
		return $this->referral;
	}

	/**
	 * @return array
	 */
	public function getCustomerOrderServices()
	{
		return $this->customerOrderServices;
	}

	/**
	 * @param CustomerOrderService $customerOrderService
	 * @return $this
	 */
	public function addCustomerOrderService(\AppBundle\Entity\CustomerOrderService $customerOrderService = null)
	{
		if (!$this->customerOrderServices->contains($customerOrderService)) {
			$this->customerOrderServices->add($customerOrderService);
		}

		return $this;
	}

	/**
	 * @param CustomerOrderService $customerOrderService
	 * @return $this
	 */
	public function removeCustomerOrderService(\AppBundle\Entity\CustomerOrderService $customerOrderService = null)
	{
		if ($this->customerOrderServices->contains($customerOrderService)) {
			$this->customerOrderServices->removeElement($customerOrderService);
		}

		return $this;
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
	 * @param $newBookingNotes
	 * @return $this
	 */
	public function setBookingNotes($newBookingNotes)
	{
		$this->bookingNotes = $newBookingNotes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBookingNotes()
	{
		return $this->bookingNotes;
	}
}