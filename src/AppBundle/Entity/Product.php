<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class Product
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
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="ProductPrice", mappedBy="product", orphanRemoval=true, cascade={"persist", "remove"})
	 * @ORM\OrderBy({"effectiveFrom" = "ASC"})
	 *
	 * @Assert\Valid()
	 */
	private $productPrices;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=32, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Length(min=3)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=128, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Length(min=3)
	 */
	private $description;

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getProductPrices()
	{
		return $this->productPrices;
	}

	/**
	 * @param \DateTime $effectiveFrom
	 * @return \AppBundle\Entity\ProductPrice
	 */
	public function getEffectiveProductPrice(\DateTime $effectiveFrom)
	{ # todo efficiency

		return $this->getProductPrices()->filter(
			function ($productPrice) use ($effectiveFrom) {
				return $productPrice->getEffectiveFrom() <= $effectiveFrom;
			}
		)->first();
	}

	/**
	 * @param \AppBundle\Entity\ProductPrice $productPrice
	 * @return $this
	 */
	public function addProductPrice(\AppBundle\Entity\ProductPrice $productPrice = null)
	{
		if (!$this->productPrices->contains($productPrice)) {
			$this->productPrices->add($productPrice);
			$productPrice->setProduct($this);
		}

		return $this;
	}

	/**
	 * @param \AppBundle\Entity\ProductPrice $productPrice
	 * @return $this
	 */
	public function removeProductPrice(\AppBundle\Entity\ProductPrice $productPrice = null)
	{
		# todo required for addProductPrice to work in form type

		return $this;
	}

	/**
	 * @param string $name
	 * @return Product
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $description
	 * @return Product
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
}
