<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as AppAssert;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use CommerceGuys\Tax\TaxableInterface;

use Money\Currency;
use Money\Money;

/**
 * Class CustomerOrder
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="customer_order", indexes={@ORM\Index(name="customer_id", columns={"customer_id"}), @ORM\Index(name="company_id", columns={"company_id"}), @ORM\Index(name="referral_id", columns={"referral_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerOrderRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CustomerOrder implements TaxableInterface
{
	use \AppBundle\Entity\Traits\Timestampable;
	use \AppBundle\Entity\Traits\Blameable;

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
	 * @AppAssert\OptionNotBlank(groups={"NewStatusBooked", "NewStatusInProgress", "NewStatusComplete"})
	 */
	private $company;

	/**
	 * @var \AppBundle\Entity\OrderType
	 *
	 * @ORM\ManyToOne(targetEntity="OrderType")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="order_type_id", referencedColumnName="id", nullable=false)
	 * })
	 *
	 * @AppAssert\OptionNotBlank(groups={"NewStatusBooked", "NewStatusInProgress", "NewStatusComplete"})
	 */
	private $orderType;

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
	 * @var \Doctrine\Common\Collections\ArrayCollection|CustomerOrderProduct[]
	 *
	 * @ORM\OneToMany(targetEntity="CustomerOrderProduct", mappedBy="customerOrder", orphanRemoval=true, cascade={"persist", "remove"})
	 *
	 * @Assert\Valid
	 */
	private $customerOrderProducts;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|CustomerOrderService[]
	 *
	 * @ORM\OneToMany(targetEntity="CustomerOrderService", mappedBy="customerOrder", orphanRemoval=true, cascade={"persist", "remove"})
	 *
	 * @Assert\Valid
	 */
	private $customerOrderServices;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|CustomerOrderTaxRateAmount[]
	 *
	 * @ORM\OneToMany(targetEntity="CustomerOrderTaxRateAmount", mappedBy="customerOrder", orphanRemoval=true, cascade={"persist", "remove"})
	 */
	private $customerOrderTaxRateAmounts;


	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|CustomerOrderStatusHistory[]
	 *
	 * @ORM\OneToMany(targetEntity="CustomerOrderStatusHistory", mappedBy="customerOrder", orphanRemoval=true, cascade={"persist", "remove"})
	 */
	private $customerOrderStatusHistories;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="status", type="string", length=3, nullable=false)
	 */
	private $status = self::STATUS_BOOKED;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_from", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"NewStatusBooked", "EditStatusBooked"})
	 */
	private $bookedFrom;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="booked_until", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"NewStatusBooked", "EditStatusBooked"})
	 *
	 * @AppAssert\DateAfter(field="bookedFrom", message="Booked Until should be after Booked From.", groups={"NewStatusBooked", "EditStatusBooked"})
	 */
	private $bookedUntil;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="booking_notes", type="text", length=65535, nullable=true)
	 *
	 * @AppAssert\NoteNotBlank(groups={"NewStatusBooked"})
	 */
	private $bookingNotes;


	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="progress_started_at", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"NewStatusInProgress", "EditStatusInProgress"})
	 *
	 * @AppAssert\DateNotFutureDated(groups={"NewStatusInProgress", "EditStatusInProgress"})
	 */
	private $progressStartedAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="progress_estimated_completion_at", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"NewStatusInProgress", "EditStatusInProgress"})
	 *
	 * @AppAssert\DateAfter(field="progressStartedAt", message="Est. Completion should be after Started.", groups={"NewStatusInProgress", "EditStatusInProgress"})
	 */
	private $progressEstimatedCompletionAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="progress_notes", type="text", length=65535, nullable=true)
	 *
	 * @AppAssert\NoteNotBlank(groups={"NewStatusInProgress"})
	 */
	private $progressNotes;


	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="completed_at", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"NewStatusComplete", "EditStatusComplete"})
	 *
	 * @AppAssert\DateNotFutureDated(groups={"NewStatusComplete", "EditStatusComplete"})
	 */
	private $completedAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="completion_notes", type="text", length=65535, nullable=true)
	 *
	 * @AppAssert\NoteNotBlank(groups={"NewStatusComplete"})
	 */
	private $completionNotes;


	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="invoiced_at", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"EditStatusInvoiced"})
	 *
	 * @AppAssert\DateNotFutureDated(groups={"EditStatusInvoiced"})
	 *
	 * @AppAssert\DateAfter(field="completedAt", message="Invoiced must be after Completion %date%.", groups={"EditStatusInvoiced"})
	 */
	private $invoicedAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="invoice_notes", type="text", length=65535, nullable=true)
	 *
	 * @AppAssert\NoteNotBlank(groups={"NewStatusInvoiced"})
	 */
	private $invoiceNotes;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="invoice_emailed_at", type="datetime", nullable=true)
	 */
	private $invoiceEmailedAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="invoice_emailed_to", type="string", length=191, nullable=true)
	 */
	private $invoiceEmailedTo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="invoice_emailed_cc", type="string", length=191, nullable=true)
	 */
	private $invoiceEmailedCc;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="invoice_subtotal_amount", type="integer", nullable=true)
	 */
	private $invoiceSubtotalAmount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="invoice_subtotal_currency", type="string", length=64, nullable=true)
	 */
	private $invoiceSubtotalCurrency;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="invoice_total_amount", type="integer", nullable=true)
	 */
	private $invoiceTotalAmount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="invoice_total_currency", type="string", length=64, nullable=true)
	 */
	private $invoiceTotalCurrency;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="paid_at", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"EditStatusPaid"})
	 *
	 * @AppAssert\DateNotFutureDated(groups={"EditStatusInvoiced"})
	 *
	 * @AppAssert\DateAfter(field="invoicedAt", message="Payment should be after Invoiced %date%.", groups={"EditStatusPaid"})
	 */
	private $paidAt;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="payment_amount", type="integer", nullable=true)
	 *
	 * @AppAssert\Decimal(message="Payment is not a proper decimal.", groups={"EditStatusPaid"})
	 */
	private $paymentAmount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="payment_currency", type="string", length=64, nullable=true)
	 */
	private $paymentCurrency = 'CAD';


	/**
	 * @var string
	 *
	 * @ORM\Column(name="payment_notes", type="text", length=65535, nullable=true)
	 *
	 * @AppAssert\NoteNotBlank(groups={"NewStatusPaid"})
	 */
	private $paymentNotes;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="cancelled_at", type="datetime", nullable=true)
	 *
	 * @AppAssert\DateNotBlank(groups={"EditStatusCancelled"})
	 *
	 * @AppAssert\DateNotFutureDated(groups={"EditStatusCancelled"})
	 */
	private $cancelledAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="cancellation_notes", type="text", length=65535, nullable=true)
	 *
	 * @AppAssert\NoteNotBlank(groups={"EditStatusCancelled"})
	 */
	private $cancellationNotes;

	/**
	 *
	 */
	public function __construct()
	{
		$this->customerOrderProducts = new \Doctrine\Common\Collections\ArrayCollection();
		$this->customerOrderServices = new \Doctrine\Common\Collections\ArrayCollection();
		$this->customerOrderTaxRateAmounts = new \Doctrine\Common\Collections\ArrayCollection();
		$this->customerOrderStatusHistories = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * @param \AppBundle\Entity\OrderType $orderType
	 *
	 * @return CustomerOrder
	 */
	public function setOrderType(OrderType $orderType = null)
	{
		$this->orderType = $orderType;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\OrderType
	 */
	public function getOrderType()
	{
		return $this->orderType;
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
	 * @return \Doctrine\Common\Collections\ArrayCollection|\AppBundle\Entity\CustomerOrderProduct[]
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
			$customerOrderProduct->setCustomerOrder(null);

		}

		return $this;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection|\AppBundle\Entity\CustomerOrderService[]
	 */
	public function getCustomerOrderServices()
	{
		return $this->customerOrderServices;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrderService $customerOrderService
	 * @return $this
	 */
	public function addCustomerOrderService(\AppBundle\Entity\CustomerOrderService $customerOrderService = null)
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
	public function removeCustomerOrderService(\AppBundle\Entity\CustomerOrderService $customerOrderService = null)
	{
		if ($this->customerOrderServices->contains($customerOrderService)) {
			$this->customerOrderServices->removeElement($customerOrderService);
			$customerOrderService->setCustomerOrder(null);
		}

		return $this;
	}

	####################################################

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
	 * @return bool
	 */
	public function isStatusBooked()
	{
		return $this->getStatus() == self::STATUS_BOOKED;
	}

	/**
	 * @return bool
	 */
	public function isStatusInProgress()
	{
		return $this->getStatus() == self::STATUS_INPROGRESS;
	}

	/**
	 * @return bool
	 */
	public function isStatusComplete()
	{
		return $this->getStatus() == self::STATUS_COMPLETE;
	}

	/**
	 * @return bool
	 */
	public function isStatusInvoiced()
	{
		return $this->getStatus() == self::STATUS_INVOICED;
	}

	/**
	 * @return bool
	 */
	public function isStatusPaid()
	{
		return $this->getStatus() == self::STATUS_PAID;
	}

	/**
	 * @return bool
	 */
	public function isStatusCancelled()
	{
		return $this->getStatus() == self::STATUS_CANCELLED;
	}

	####################################################

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
	 * @param $progressEstimatedCompletionAt
	 * @return $this
	 */
	public function setProgressEstimatedCompletionAt($progressEstimatedCompletionAt)
	{
		$this->progressEstimatedCompletionAt = $progressEstimatedCompletionAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getProgressEstimatedCompletionAt()
	{
		return $this->progressEstimatedCompletionAt;
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
	 * TaxableInterface
	 * @return bool
	 */
	public function isPhysical()
	{
		return true;
	}

	/**
	 * @param \DateTime $invoicedAt
	 * @return $this
	 */
	public function setInvoicedAt(\DateTime $invoicedAt)
	{
		$this->invoicedAt = $invoicedAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getInvoicedAt()
	{
		return $this->invoicedAt;
	}

	/**
	 * @param \DateTime $invoiceEmailedAt
	 * @return $this
	 */
	public function setInvoiceEmailedAt(\DateTime $invoiceEmailedAt)
	{
		$this->invoiceEmailedAt = $invoiceEmailedAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getInvoiceEmailedAt()
	{
		return $this->invoiceEmailedAt;
	}

	/**
	 * @return string
	 */
	public function getInvoiceEmailedTo()
	{
		return $this->invoiceEmailedTo;
	}

	/**
	 * @param $invoiceEmailedTo
	 * @return $this
	 */
	public function setInvoiceEmailedTo($invoiceEmailedTo)
	{
		$this->invoiceEmailedTo = $invoiceEmailedTo;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getInvoiceEmailedCc()
	{
		return $this->invoiceEmailedCc;
	}

	/**
	 * @param $invoiceEmailedCc
	 * @return $this
	 */
	public function setInvoiceEmailedCc($invoiceEmailedCc)
	{
		$this->invoiceEmailedCc = $invoiceEmailedCc;

		return $this;
	}

	/**
	 * @return Money|null
	 */
	public function getInvoiceSubtotal()
	{
		if (!$this->invoiceSubtotalCurrency) {
			return null;
		}
		if (!$this->invoiceSubtotalAmount) {
			return new Money(0, new Currency($this->invoiceSubtotalCurrency));
		}

		return new Money($this->invoiceSubtotalAmount, new Currency($this->invoiceSubtotalCurrency));
	}

	/**
	 * @param Money $invoiceSubtotal
	 * @return $this
	 */
	public function setInvoiceSubtotal(Money $invoiceSubtotal)
	{
		if (!is_null($invoiceSubtotal)) {
			$this->invoiceSubtotalAmount = $invoiceSubtotal->getAmount();
			$this->invoiceSubtotalCurrency = $invoiceSubtotal->getCurrency()->getName();
		}

		return $this;
	}

	/**
	 * @return Money|null
	 */
	public function getInvoiceTotal()
	{
		if (!$this->invoiceTotalCurrency) {
			return null;
		}
		if (!$this->invoiceTotalAmount) {
			return new Money(0, new Currency($this->invoiceTotalCurrency));
		}

		return new Money($this->invoiceTotalAmount, new Currency($this->invoiceTotalCurrency));
	}

	/**
	 * @param Money $invoiceTotal
	 * @return $this
	 */
	public function setInvoiceTotal(Money $invoiceTotal)
	{
		if (!is_null($invoiceTotal)) {
			$this->invoiceTotalAmount = $invoiceTotal->getAmount();
			$this->invoiceTotalCurrency = $invoiceTotal->getCurrency()->getName();
		}

		return $this;
	}

	/**
	 * @param $invoiceNotes
	 * @return $this
	 */
	public function setInvoiceNotes($invoiceNotes)
	{
		$this->invoiceNotes = $invoiceNotes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getInvoiceNotes()
	{
		return $this->invoiceNotes;
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection|CustomerOrderTaxRateAmount[] $customerOrderTaxRateAmounts
	 * @return $this
	 */
	public function setCustomerOrderTaxRateAmounts(\Doctrine\Common\Collections\ArrayCollection $customerOrderTaxRateAmounts)
	{
		## todo remove tax rate?

		foreach ($customerOrderTaxRateAmounts as $newCustomerOrderTaxRateAmount) {
			$found = false;

			/** @var CustomerOrderTaxRateAmount $thisCustomerOrderTaxRateAmount */
			foreach ($this->customerOrderTaxRateAmounts as $thisCustomerOrderTaxRateAmount) {
				if ($thisCustomerOrderTaxRateAmount->getTaxRateAmount() == $newCustomerOrderTaxRateAmount->getTaxRateAmount()) {
					$thisCustomerOrderTaxRateAmount->setTaxes($newCustomerOrderTaxRateAmount->getTaxes());
					$found = true;
					break;
				}
			}

			if (!$found) {
				$this->addCustomerOrderTaxRateAmount($newCustomerOrderTaxRateAmount);
			}
		}

		return $this;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getCustomerOrderTaxRateAmounts()
	{
		return $this->customerOrderTaxRateAmounts;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrderTaxRateAmount $customerOrderTaxRateAmount
	 * @return $this
	 */
	public function addCustomerOrderTaxRateAmount(CustomerOrderTaxRateAmount $customerOrderTaxRateAmount = null)
	{
		if (!$this->customerOrderTaxRateAmounts->contains($customerOrderTaxRateAmount)) {
			$customerOrderTaxRateAmount->setCustomerOrder($this);
			$this->customerOrderTaxRateAmounts->add($customerOrderTaxRateAmount);
		}

		return $this;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrderTaxRateAmount $customerOrderTaxRateAmount
	 * @return $this
	 */
	public function removeCustomerOrderTaxRateAmount(CustomerOrderTaxRateAmount $customerOrderTaxRateAmount = null)
	{
		if ($this->customerOrderTaxRateAmounts->contains($customerOrderTaxRateAmount)) {
			$this->customerOrderTaxRateAmounts->removeElement($customerOrderTaxRateAmount);
			$customerOrderTaxRateAmount->setCustomerOrder(null);
		}

		return $this;
	}

	####################################################

	/**
	 * @param $paidAt
	 * @return $this
	 */
	public function setPaidAt($paidAt)
	{
		$this->paidAt = $paidAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getPaidAt()
	{
		return $this->paidAt;
	}

	/**
	 * @param $paymentNotes
	 * @return $this
	 */
	public function setPaymentNotes($paymentNotes)
	{
		$this->paymentNotes = $paymentNotes;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPaymentNotes()
	{
		return $this->paymentNotes;
	}

	/**
	 * @return Money|null
	 */
	public function getPayment()
	{
		## currency is defaulted CAD, amount is defaulted null
		if (!$this->paymentCurrency) {
			return null;
		}

		if (!$this->paymentAmount) {
			return new Money(0, new Currency($this->paymentCurrency));
		}

		return new Money($this->paymentAmount, new Currency($this->paymentCurrency));
	}

	/**
	 * @param Money $payment
	 * @return $this
	 */
	public function setPayment(Money $payment = null)
	{
		if (!is_null($payment)) {
			$this->paymentAmount = $payment->getAmount();
			$this->paymentCurrency = $payment->getCurrency()->getName();
		}

		return $this;
	}

	####################################################

	/**
	 * @param $cancelledAt
	 * @return $this
	 */
	public function setCancelledAt($cancelledAt)
	{
		$this->cancelledAt = $cancelledAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCancelledAt()
	{
		return $this->cancelledAt;
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
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getCustomerOrderStatusHistories()
	{
		return $this->customerOrderStatusHistories;
	}

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