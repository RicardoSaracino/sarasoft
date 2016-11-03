<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
	 * @var integer
	 *
	 * @ORM\Column(name="quantity", type="integer", nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Range(min="1")
	 */
	private $quantity;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="comments", type="integer", nullable=false)
	 */
	private $comments;

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
	 * @Assert\NotBlank()
	 */
	private $service;

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
	 * @return CustomerOrderService
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
	 * @param integer $comments
	 *
	 * @return CustomerOrderService
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;

		return $this;
	}

	/**
	 * Get comments
	 *
	 * @return integer
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
	 * @return CustomerOrderService
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
	 * Set service
	 *
	 * @param \AppBundle\Entity\Service $service
	 *
	 * @return CustomerOrderService
	 */
	public function setService(\AppBundle\Entity\Service $service)
	{
		$this->service = $service;

		return $this;
	}

	/**
	 * Get service
	 *
	 * @return \AppBundle\Entity\Service
	 */
	public function getService()
	{
		return $this->service;
	}
}