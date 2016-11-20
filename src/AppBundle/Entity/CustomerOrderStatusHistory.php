<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrderStatusHistory
 *
 * @ORM\Table(name="customer_order_status_history",  indexes={@ORM\Index(name="customer_order_id", columns={"customer_order_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class CustomerOrderStatusHistory
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
	 * @ORM\ManyToOne(targetEntity="CustomerOrder")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="customer_order_id", referencedColumnName="id", nullable=false)
	 * })
	 */
	private $customerOrder;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="old_status", type="string", length=32, nullable=false)
	 */
	private $oldStatus;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="new_status", type="string", length=32, nullable=false)
	 */
	private $newStatus;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \AppBundle\Entity\CustomerOrder $customerOrder
	 * @return CustomerOrder
	 */
	public function setCustomerOrder(CustomerOrder $customerOrder = null)
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
	 * @param $oldStatus
	 * @return $this
	 */
	public function setOldStatus($oldStatus)
	{
		$this->oldStatus = $oldStatus;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOldStatus()
	{
		return $this->oldStatus;
	}

	/**
	 * @param $newStatus
	 * @return $this
	 */
	public function setNewStatus($newStatus)
	{
		$this->newStatus = $newStatus;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->newStatus;
	}
}
