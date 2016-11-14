<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CustomerOrderProduct
 *
 * @ORM\Table(name="customer_order_product", uniqueConstraints={@ORM\UniqueConstraint(name="customer_order_id", columns={"customer_order_id", "product_id"})}, indexes={@ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="IDX_7382439AA15A2E17", columns={"customer_order_id"})})
 * @ORM\Entity
 */
class CustomerOrderProduct
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
	 * @var integer
	 *
	 * @ORM\Column(name="quantity", type="integer", nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Range(min="1")
	 */
	private $quantity;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="comments", type="string", length=256, nullable=true)
	 */
	private $comments;

	/**
	 * @var \AppBundle\Entity\CustomerOrder
	 *
	 * @ORM\ManyToOne(targetEntity="CustomerOrder", inversedBy="customerOrderProducts")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="customer_order_id", referencedColumnName="id")
	 * })
	 */
	private $customerOrder;

	/**
	 * @var \AppBundle\Entity\Product
	 *
	 * @ORM\OneToOne(targetEntity="Product")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
	 * })
	 *
	 * @Assert\NotBlank()
	 */
	private $product;

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set quantity
	 *
	 * @param integer $quantity
	 *
	 * @return CustomerOrderProduct
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	/**
	 * Get quantity
	 *
	 * @return integer
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * Set comments
	 *
	 * @param string $comments
	 *
	 * @return CustomerOrderProduct
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;

		return $this;
	}

	/**
	 * Get comments
	 *
	 * @return string
	 */
	public function getComments()
	{
		return $this->comments;
	}

	/**
	 * Set customerOrder
	 *
	 * @param \AppBundle\Entity\CustomerOrder $customerOrder
	 *
	 * @return CustomerOrderProduct
	 */
	public function setCustomerOrder(\AppBundle\Entity\CustomerOrder $customerOrder)
	{
		$this->customerOrder = $customerOrder;

		return $this;
	}

	/**
	 * Get customerOrder
	 *
	 * @return \AppBundle\Entity\CustomerOrder
	 */
	public function getCustomerOrder()
	{
		return $this->customerOrder;
	}

	/**
	 * Set product
	 *
	 * @param \AppBundle\Entity\Product $product
	 *
	 * @return CustomerOrderProduct
	 */
	public function setProduct(\AppBundle\Entity\Product $product)
	{
		$this->product = $product;

		return $this;
	}

	/**
	 * Get product
	 *
	 * @return \AppBundle\Entity\Product
	 */
	public function getProduct()
	{
		return $this->product;
	}
}