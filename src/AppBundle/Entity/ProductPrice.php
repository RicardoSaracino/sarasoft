<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ProductPrice
 *
 * @ORM\Table(name="product_price", uniqueConstraints={@ORM\UniqueConstraint(name="product_effective_from", columns={"product_id,effective_from"})}, indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="effective_from", columns={"effective_from"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 *
 * todo UniqueEntity(
 *    fields={product_id,effective_from}
 *    errorPath="effective_from",
 *    message="This product is already effective on this date."
 * )
 */
class ProductPrice
{
	use \AppBundle\Entity\Traits\Priceable;
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
	 * @var \AppBundle\Entity\Product
	 *
	 * @ORM\ManyToOne(targetEntity="Product", inversedBy="productPrices")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
	 * })
	 */
	private $product;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \AppBundle\Entity\Product $product
	 * @return CustomerOrderProduct
	 */
	public function setProduct(\AppBundle\Entity\Product $product)
	{
		$this->product = $product;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\Product
	 */
	public function getProduct()
	{
		return $this->product;
	}
}