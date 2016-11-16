<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CustomerOrders
 *
 * @ORM\Table(name="customer_order", indexes={@ORM\Index(name="customer_id", columns={"customer_id"}), @ORM\Index(name="company_id", columns={"company_id"}), @ORM\Index(name="referral_id", columns={"referral_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class CustomerOrder
{
	use Traits\Timestampable;
	use Traits\Blameable;

	const STATUS_BOOKED = 'customerOrder.status.booked';
	const STATUS_INPROGRESS = 'customerOrder.status.inprogress';
	const STATUS_COMPLETE = 'customerOrder.status.complete';
	const STATUS_INVOICED = 'customerOrder.status.invoiced';
	const STATUS_PAID = 'customerOrder.status.paid';
	const STATUS_CANCELLED = 'customerOrder.status.cancelled';

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
	 * @Assert\NotBlank(groups={"StatusBooked"})
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
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="CustomerOrderProduct", mappedBy="customerOrder", orphanRemoval=true, cascade={"persist", "remove"})
	 *
	 * @Assert\Valid()
	 */
	private $customerOrderProducts;
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="CustomerOrderService", mappedBy="customerOrder", orphanRemoval=true, cascade={"persist", "remove"})
	 *
	 * @Assert\Valid()
	 */
	private $customerOrderServices;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="status", type="string", length=3, nullable=false)
	 */
	private $status = self::STATUS_BOOKED;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_from", type="datetime", nullable=false)
	 *
	 * @Assert\NotBlank(groups={"StatusBooked"})
	 */
	private $bookedFrom;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_until", type="datetime", nullable=false)
	 *
	 * @Assert\NotBlank(groups={"StatusBooked"})
	 */
	private $bookedUntil;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="booking_notes", type="text", length=65535, nullable=false)
	 *
	 * @Assert\NotBlank(message="Booking Notes should not be blank", groups={"StatusBooked"})
	 */
	private $bookingNotes;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="progress_started_at", type="datetime", nullable=true)
	 *
	 * @Assert\NotBlank(groups={"StatusInProgress"})
	 */
	private $progressStartedAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="progress_notes", type="text", length=65535, nullable=true)
	 *
	 * @Assert\NotBlank(message="Progress Notes should not be blank", groups={"StatusInProgress"})
	 */
	private $progressNotes;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="completed_at", type="datetime", nullable=true)
	 *
	 * @Assert\NotBlank(groups={"StatusComplete"})
	 */
	private $completedAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="completion_notes", type="text", length=65535, nullable=true)
	 *
	 * @Assert\NotBlank(message="Completion Notes should not be blank", groups={"StatusComplete"})
	 */
	private $completionNotes;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="cancelled_on", type="datetime", nullable=true)
	 *
	 * @Assert\NotBlank(groups={"StatusCancelled"})
	 */
	private $cancelledOn;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="cancellation_notes", type="text", length=65535, nullable=true)
	 *
	 * @Assert\NotBlank(message="Cancellation Notes should not be blank", groups={"StatusCancelled"})
	 */
	private $cancellationNotes;

	/**
	 *
	 */
	public function __construct()
	{
		$this->customerOrderProducts = new \Doctrine\Common\Collections\ArrayCollection();
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
	public function setCustomer(Customer $customer = null)
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
	public function setCompany(Company $company = null)
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
	public function setReferral(Referral $referral = null)
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
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getCustomerOrderProducts()
	{
		return $this->customerOrderProducts;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrderProduct $customerOrderProduct
	 * @return $this
	 */
	public function addCustomerOrderProduct(CustomerOrderProduct $customerOrderProduct = null)
	{
		if (!$this->customerOrderProducts->contains($customerOrderProduct)) {
			$customerOrderProduct->setCustomerOrder($this);
			$this->customerOrderProducts->add($customerOrderProduct);
		}

		return $this;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrderProduct $customerOrderProduct
	 * @return $this
	 */
	public function removeCustomerOrderProduct(CustomerOrderProduct $customerOrderProduct = null)
	{
		if ($this->customerOrderProducts->contains($customerOrderProduct)) {
			$this->customerOrderProducts->removeElement($customerOrderProduct);
		}

		return $this;
	}
	
	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getCustomerOrderServices()
	{
		return $this->customerOrderServices;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrderService $customerOrderService
	 * @return $this
	 */
	public function addCustomerOrderService(CustomerOrderService $customerOrderService = null)
	{
		if (!$this->customerOrderServices->contains($customerOrderService)) {
			$customerOrderService->setCustomerOrder($this);
			$this->customerOrderServices->add($customerOrderService);
		}

		return $this;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrderService $customerOrderService
	 * @return $this
	 */
	public function removeCustomerOrderService(CustomerOrderService $customerOrderService = null)
	{
		if ($this->customerOrderServices->contains($customerOrderService)) {
			$this->customerOrderServices->removeElement($customerOrderService);
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @param $status
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function setStatus($status)
	{
		if (!in_array($status, array(self::STATUS_BOOKED, self::STATUS_INPROGRESS, self::STATUS_COMPLETE, self::STATUS_INVOICED, self::STATUS_PAID, self::STATUS_CANCELLED))) {
			throw new \InvalidArgumentException('Invalid status');
		}

		$this->status = $status;

		return $this;
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
	 * @param $bookingNotes
	 * @return $this
	 */
	public function setBookingNotes($bookingNotes)
	{
		$this->bookingNotes = $bookingNotes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBookingNotes()
	{
		return $this->bookingNotes;
	}

 	####################################################

	/**
	 * @param $progressStartedAt
	 * @return $this
	 */
	public function setProgressStartedAt($progressStartedAt)
	{
		$this->progressStartedAt = $progressStartedAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getProgressStartedAt()
	{
		return $this->progressStartedAt;
	}

	/**
	 * @param $progressNotes
	 * @return $this
	 */
	public function setProgressNotes($progressNotes)
	{
		$this->progressNotes = $progressNotes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getProgressNotes()
	{
		return $this->progressNotes;
	}

	####################################################

	/**
	 * @param $completedAt
	 * @return $this
	 */
	public function setCompletedAt($completedAt)
	{
		$this->completedAt = $completedAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCompletedAt()
	{
		return $this->completedAt;
	}

	/**
	 * @param $completionNotes
	 * @return $this
	 */
	public function setCompletionNotes($completionNotes)
	{
		$this->completionNotes = $completionNotes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCompletionNotes()
	{
		return $this->completionNotes;
	}

 	####################################################

	/**
	 * @param $cancelledOn
	 * @return $this
	 */
	public function setCancelledOn($cancelledOn)
	{
		$this->cancelledOn = $cancelledOn;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCancelledOn()
	{
		return $this->cancelledOn;
	}

	/**
	 * @param $cancellationNotes
	 * @return $this
	 */
	public function setCancellationNotes($cancellationNotes)
	{
		$this->cancellationNotes = $cancellationNotes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCancellationNotes()
	{
		return $this->cancellationNotes;
	}

	####################################################

	/**
	 * @ORM\PostUpdate
	 */
	public function postUpdate(\Doctrine\ORM\Event\LifecycleEventArgs $args)
	{
		if ($args->getEntity() instanceof CustomerOrder) {

			$changeSet = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($args->getEntity());

			if (array_key_exists('status', $changeSet)) {

				$customerOrderStatusHistory = new CustomerOrderStatusHistory();

				$customerOrderStatusHistory->setCustomerOrder($this);
				$customerOrderStatusHistory->setOldStatus($changeSet['status'][0]);
				$customerOrderStatusHistory->setNewStatus($changeSet['status'][1]);

				$args->getEntityManager()->persist($customerOrderStatusHistory);
				$args->getEntityManager()->flush();
			}
		}
	}
}