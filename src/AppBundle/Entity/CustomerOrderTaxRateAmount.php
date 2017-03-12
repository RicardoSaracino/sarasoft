<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Money\Currency;
use Money\Money;

/**
 * CustomerOrderTaxRateAmount
 *
 * @ORM\Table(name="customer_order_tax_rate_amount", uniqueConstraints={@ORM\UniqueConstraint(name="customer_order_id", columns={"customer_order_id", "tax_rate_amount_id"})}, indexes={@ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="tax_rate_amount_id", columns={"tax_rate_amount_id"}), @ORM\Index(name="IDX_3E8D13D6A15A2E17", columns={"customer_order_id"})})
 * @ORM\Entity
 */
class CustomerOrderTaxRateAmount
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
	 * @var \AppBundle\Entity\CustomerOrder
	 *
	 * @ORM\ManyToOne(targetEntity="CustomerOrder", inversedBy="customerOrderTaxRateAmounts")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="customer_order_id", referencedColumnName="id")
	 * })
	 */
	private $customerOrder;

	/**
	 * @var \AppBundle\Entity\TaxRateAmount
	 *
	 * @ORM\ManyToOne(targetEntity="TaxRateAmount")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="tax_rate_amount_id", referencedColumnName="id")
	 * })
	 */
	private $taxRateAmount;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="taxes_amount", type="integer", nullable=false)
	 */
	private $taxesAmount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="taxes_currency", type="string", length=64, nullable=false)
	 */
	private $taxesCurrency;


	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrder $customerOrder
	 * @return $this
	 */
	public function setCustomerOrder(\AppBundle\Entity\CustomerOrder $customerOrder = null)
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
	 * @param \AppBundle\Entity\TaxRateAmount $taxRateAmount
	 * @return $this
	 */
	public function setTaxRateAmount(\AppBundle\Entity\TaxRateAmount $taxRateAmount)
	{
		$this->taxRateAmount = $taxRateAmount;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\TaxRateAmount
	 */
	public function getTaxRateAmount()
	{
		return $this->taxRateAmount;
	}

	/**
	 * @return Money|null
	 */
	public function getTaxes()
	{
		if (!$this->taxesCurrency) {
			return null;
		}

		if (!$this->taxesAmount) {
			return new Money(0, new Currency($this->taxesCurrency));
		}

		return new Money($this->taxesAmount, new Currency($this->taxesCurrency));
	}

	/**
	 * @param Money $taxes
	 * @return $this
	 */
	public function setTaxes(Money $taxes)
	{
		if (!$this->taxesCurrency) {
			$this->taxesAmount = $taxes->getAmount();
			$this->taxesCurrency = $taxes->getCurrency()->getName();
		}

		return $this;
	}
}