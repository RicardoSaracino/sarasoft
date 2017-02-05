<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use CommerceGuys\Tax\Model\TaxTypeEntityInterface;
use CommerceGuys\Tax\Model\TaxRateEntityInterface;
use CommerceGuys\Tax\Model\TaxRateAmountEntityInterface;

/**
 * TaxRate
 *
 * @see https://github.com/commerceguys/tax/blob/master/src/Model/TaxRate.php
 *
 * @ORM\Table(name="tax_rate", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="tax_type_id", columns={"tax_type_id"})})
 * @ORM\Entity
 */
class TaxRate implements TaxRateEntityInterface
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
	 * @var \AppBundle\Entity\TaxType
	 *
	 * @ORM\ManyToOne(targetEntity="TaxType", inversedBy="taxRates"))
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="tax_type_id", referencedColumnName="id")
	 * })
	 */
	private $taxType;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="TaxRateAmount", mappedBy="taxRate", fetch="EAGER", orphanRemoval=true, cascade={"persist", "remove"})
	 */
	private $taxRateAmounts;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=64, nullable=false)
	 */
	private $name;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="default", type="boolean", nullable=false)
	 */
	private $default;

	/**
	 *
	 */
	public function __construct()
	{
		$this->taxRateAmounts = new ArrayCollection();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return $this->taxType;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setType(TaxTypeEntityInterface $taxType = null)
	{
		$this->taxType = $taxType;

		return $this;
	}

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
	public function getName()
	{
		return $this->name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isDefault()
	{
		return !empty($this->default);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefault($default)
	{
		$this->default = $default;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAmounts()
	{
		return $this->taxRateAmounts;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setAmounts(Collection $taxRateAmounts)
	{
		$this->taxRateAmounts = $taxRateAmounts;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasAmounts()
	{
		return !$this->taxRateAmounts->isEmpty();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAmount(\DateTime $date = null)
	{
		if (is_null($date)) {
			// Initialize DateTime to the current date.
			$date = new \DateTime();
		}
		// Amount start/end dates don't include the time, so discard the time
		// portion of the provided date to make the matching precise.
		$date->setTime(0, 0);
		foreach ($this->taxRateAmounts as $amount) {
			$startDate = $amount->getStartDate();
			$endDate = $amount->getEndDate();
			// Match the date against the optional amount start/end dates.
			if ((!$startDate || $startDate <= $date) && (!$endDate || $endDate > $date)) {
				return $amount;
			}
		}

		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addAmount(TaxRateAmountEntityInterface $taxRateAmount)
	{
		if (!$this->hasAmount($taxRateAmount)) {
			$taxRateAmount->setRate($this);
			$this->taxRateAmounts->add($taxRateAmount);
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function removeAmount(TaxRateAmountEntityInterface $taxRateAmount)
	{
		if ($this->hasAmount($taxRateAmount)) {
			$taxRateAmount->setRate(null);
			$this->taxRateAmounts->removeElement($taxRateAmount);
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasAmount(TaxRateAmountEntityInterface $taxRateAmount)
	{
		return $this->taxRateAmounts->contains($taxRateAmount);
	}
}

