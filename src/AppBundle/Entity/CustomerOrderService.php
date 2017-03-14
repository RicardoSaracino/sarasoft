<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Money\Currency;
use Money\Money;

/**
 * CustomerOrderService
 *
 * @ORM\Table(name="customer_order_service", uniqueConstraints={@ORM\UniqueConstraint(name="customer_order_id", columns={"customer_order_id", "service_id"})}, indexes={@ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="service_id", columns={"service_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="IDX_7382439AA15A2E17", columns={"customer_order_id"})})
 * @ORM\Entity
 */
class CustomerOrderService
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
	 * @var \AppBundle\Entity\CustomerOrder
	 *
	 * @ORM\ManyToOne(targetEntity="CustomerOrder", inversedBy="customerOrderServices")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="customer_order_id", referencedColumnName="id")
	 * })
	 */
	private $customerOrder;

	/**
	 * @var \AppBundle\Entity\Service
	 *
	 * @ORM\OneToOne(targetEntity="Service")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
	 * })
	 *
	 * @Assert\NotBlank(message="Select an option.", groups={"NewStatusInProgress", "EditStatusInProgress", "EditStatusComplete"})
	 */
	private $service;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="quantity", type="integer", nullable=false)
	 *
	 * @Assert\NotBlank(groups={"NewStatusInProgress", "EditStatusInProgress", "EditStatusComplete"})
	 * @Assert\Range(min="1", groups={"NewStatusInProgress", "EditStatusInProgress", "EditStatusComplete"})
	 */
	private $quantity;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="comments", type="string", length=256, nullable=true)
	 */
	private $comments;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="invoice_price_amount", type="integer", nullable=true)
	 */
	private $invoicePriceAmount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="invoice_price_currency", type="string", length=64, nullable=true)
	 */
	private $invoicePriceCurrency;

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrder $customerOrder
	 * @return CustomerOrderService
	 */
	public function setCustomerOrder(\AppBundle\Entity\CustomerOrder $customerOrder)
	{
		$this->customerOrder = $customerOrder;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\CustomerOrder
	 */
	public function getCustomerOrder()
	{
		return $this->customerOrder;
	}

	/**
	 * @param \AppBundle\Entity\Service $service
	 * @return CustomerOrderService
	 */
	public function setService(\AppBundle\Entity\Service $service)
	{
		$this->service = $service;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\Service
	 */
	public function getService()
	{
		return $this->service;
	}

	/**
	 * @param integer $quantity
	 * @return CustomerOrderService
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	/**
	 * @return integer
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @param string $comments
	 * @return CustomerOrderService
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getComments()
	{
		return $this->comments;
	}


	/**
	 * @return Money|null
	 */
	public function getInvoicePrice()
	{
		if (!$this->invoicePriceCurrency) {
			return null;
		}

		if (!$this->invoicePriceAmount) {
			return new Money(0, new Currency($this->invoicePriceCurrency));
		}

		return new Money($this->invoicePriceAmount, new Currency($this->invoicePriceCurrency));
	}

	/**
	 * @param Money $invoicePrice
	 * @return $this
	 */
	public function setInvoicePrice(Money $invoicePrice)
	{
		if (!is_null($invoicePrice)) {
			$this->invoicePriceAmount = $invoicePrice->getAmount();
			$this->invoicePriceCurrency = $invoicePrice->getCurrency()->getName();
		}

		return $this;
	}

	/**
	 * @return Money
	 */
	public function getInvoiceAmount()
	{
		return $this->getInvoicePrice()->multiply($this->getQuantity());
	}
}