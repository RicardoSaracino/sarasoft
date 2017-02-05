<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CommerceGuys\Tax\Model\TaxRateAmountEntityInterface;
use CommerceGuys\Tax\Model\TaxRateEntityInterface;

/**
 * TaxRateAmount
 *
 * @see https://github.com/commerceguys/tax/blob/master/src/Model/TaxRateAmount.php
 *
 * @ORM\Table(name="tax_rate_amount", indexes={@ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="tax_rate_id", columns={"tax_rate_id"}), @ORM\Index(name="created_by", columns={"created_by"})})
 * @ORM\Entity
 */
class TaxRateAmount implements TaxRateAmountEntityInterface
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
	 * @var \AppBundle\Entity\TaxRate
	 *
	 * @ORM\ManyToOne(targetEntity="TaxRate")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="tax_rate_id", referencedColumnName="id")
	 * })
	 */
	private $taxRate;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=6, scale=4, nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRate()
	{
		return $this->taxRate;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setRate(TaxRateEntityInterface $taxRate = null)
	{
		$this->taxRate = $taxRate;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setStartDate(\DateTime $startDate)
	{
		$this->startDate = $startDate;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEndDate()
	{
		return $this->endDate;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setEndDate(\DateTime $endDate)
	{
		$this->endDate = $endDate;
		return $this;
	}
}

