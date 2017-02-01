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
	 * @Assert\NotBlank(groups={"StatusComplete"})
	 */
	private $service;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="quantity", type="integer", nullable=false)
	 *
	 * @Assert\NotBlank(groups={"StatusComplete"})
	 * @Assert\Range(min="1", groups={"StatusComplete"})
	 */
	private $quantity;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="comments", type="string", length=256, nullable=true)
	 */
	private $comments;


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
	 * @return \Money\Money
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 */
	public function getEffectivePrice()
	{
		if ($servicePrice = $this->service->getEffectiveServicePrice($this->getCustomerOrder()->getCompletedAt())) {
			return $servicePrice->getPrice();
		}

		# todo handle not finding a price for the date
		throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, sprintf('Service "%s" has no effective price before "%s"', $this->service->getName(), $this->customerOrder->getCompletedAt()->format('Y-m-d')));
	}

	/**
	 * @return \Money\Money
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 */
	public function getEffectivePriceAmount()
	{
		if ($servicePrice = $this->service->getEffectiveServicePrice($this->getCustomerOrder()->getCompletedAt())) {
			return $servicePrice->getPrice()->multiply($this->getQuantity());
		}

		# todo handle not finding a price for the date
		throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, sprintf('Service "%s" has no effective price before "%s"', $this->service->getName(), $this->customerOrder->getCompletedAt()->format('Y-m-d')));
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
}