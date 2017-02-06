<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use CommerceGuys\Zone\Model\ZoneEntityInterface;
use CommerceGuys\Tax\Enum\GenericLabel;
use CommerceGuys\Tax\Model\TaxTypeEntityInterface;
use CommerceGuys\Tax\Model\TaxRateEntityInterface;

/**
 * TaxType
 *
 * @ORM\Table(name="tax_type", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="zone_id", columns={"zone_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxTypeRepository")
 */
class TaxType implements TaxTypeEntityInterface
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
	 * @var \CommerceGuys\Zone\Model\ZoneEntityInterface
	 *
	 * @ORM\ManyToOne(targetEntity="Zone")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
	 * })
	 */
	private $zone;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="TaxRate", mappedBy="taxType", fetch="EAGER", orphanRemoval=true, cascade={"persist", "remove"})
	 */
	private $taxRates;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=64, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="generic_label", type="string", length=64, nullable=false)
	 */
	private $genericLabel;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="compound", type="boolean", nullable=false)
	 */
	private $compound;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="display_inclusive", type="boolean", nullable=false)
	 */
	private $displayInclusive;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="rounding_mode", type="string", length=32, nullable=false)
	 */
	private $roundingMode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="tag", type="string", length=32, nullable=false)
	 */
	private $tag;

	/**
	 *
	 */
	public function __construct()
	{
		$this->genericLabel = GenericLabel::getDefault();
		$this->taxRates = new ArrayCollection();
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
	public function getGenericLabel()
	{
		return $this->genericLabel;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setGenericLabel($genericLabel)
	{
		GenericLabel::assertExists($genericLabel);
		$this->genericLabel = $genericLabel;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isCompound()
	{
		return !empty($this->compound);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCompound($compound)
	{
		$this->compound = $compound;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isDisplayInclusive()
	{
		return !empty($this->displayInclusive);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDisplayInclusive($displayInclusive)
	{
		$this->displayInclusive = $displayInclusive;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRoundingMode()
	{
		return $this->roundingMode;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setRoundingMode($roundingMode)
	{
		$this->roundingMode = $roundingMode;

		return $this;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getMoneyRoundingMode()
	{
		return $this->roundingMode;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getZone()
	{
		return $this->zone;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setZone(ZoneEntityInterface $zone)
	{
		$this->zone = $zone;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setTag($tag)
	{
		$this->tag = $tag;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRates()
	{
		return $this->taxRates;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setRates(Collection $taxRates)
	{
		$this->taxRates = $taxRates;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasRates()
	{
		return !$this->taxRates->isEmpty();
	}

	/**
	 * {@inheritdoc}
	 */
	public function addRate(TaxRateEntityInterface $taxRates)
	{
		if (!$this->hasRate($taxRates)) {
			$taxRates->setType($this);
			$this->taxRates->add($taxRates);
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function removeRate(TaxRateEntityInterface $rate)
	{
		if ($this->hasRate($rate)) {
			$this->taxRates->removeElement($rate);
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasRate(TaxRateEntityInterface $rate)
	{
		return $this->taxRates->contains($rate);
	}
}

