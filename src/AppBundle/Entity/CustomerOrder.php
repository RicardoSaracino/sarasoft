<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * CustomerOrders
 *
 * @ORM\Table(name="customer_order", indexes={@ORM\Index(name="customer_id", columns={"customer_id"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class CustomerOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

	/**
	 * @var \AppBundle\Entity\Customer
	 *
	 * @ORM\ManyToOne(targetEntity="Customer")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
	 * })
	 */
	private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="order_status_code", type="string", length=3, nullable=false)
     */
    private $orderStatusCode = 'BKD';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="booked_for", type="date", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
    private $bookedFor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_on", type="date", nullable=true)
     */
    private $startedOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finished_on", type="date", nullable=true)
     */
    private $finishedOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="paid_on", type="date", nullable=true)
     */
    private $paidOn;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", length=65535, nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
    private $details;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 *
	 * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

	/**
	 * @var \AppBundle\Entity\User
	 *
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="created_by", referencedColumnName="id")
	 * })
	 *
	 * @Gedmo\Blameable(on="create")
	 */
	private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 *
	 * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     * })
	 *
	 * @Gedmo\Blameable(on="update")
	 */
    private $updatedBy;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set orderStatusCode
     *
     * @param string $orderStatusCode
     *
     * @return CustomerOrders
     */
    public function setOrderStatusCode($orderStatusCode)
    {
        $this->orderStatusCode = $orderStatusCode;

        return $this;
    }

    /**
     * Get orderStatusCode
     *
     * @return string
     */
    public function getOrderStatusCode()
    {
        return $this->orderStatusCode;
    }

    /**
     * Set bookedFor
     *
     * @param \DateTime $bookedFor
     *
     * @return CustomerOrders
     */
    public function setBookedFor($bookedFor)
    {
        $this->bookedFor = $bookedFor;

        return $this;
    }

    /**
     * Get bookedFor
     *
     * @return \DateTime
     */
    public function getBookedFor()
    {
        return $this->bookedFor;
    }

    /**
     * Set startedOn
     *
     * @param \DateTime $startedOn
     *
     * @return CustomerOrders
     */
    public function setStartedOn($startedOn)
    {
        $this->startedOn = $startedOn;

        return $this;
    }

    /**
     * Get startedOn
     *
     * @return \DateTime
     */
    public function getStartedOn()
    {
        return $this->startedOn;
    }

    /**
     * Set finishedOn
     *
     * @param \DateTime $finishedOn
     *
     * @return CustomerOrders
     */
    public function setFinishedOn($finishedOn)
    {
        $this->finishedOn = $finishedOn;

        return $this;
    }

    /**
     * Get finishedOn
     *
     * @return \DateTime
     */
    public function getFinishedOn()
    {
        return $this->finishedOn;
    }

    /**
     * Set paidOn
     *
     * @param \DateTime $paidOn
     *
     * @return CustomerOrders
     */
    public function setPaidOn($paidOn)
    {
        $this->paidOn = $paidOn;

        return $this;
    }

    /**
     * Get paidOn
     *
     * @return \DateTime
     */
    public function getPaidOn()
    {
        return $this->paidOn;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return CustomerOrders
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CustomerOrders
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return CustomerOrders
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return CustomerOrders
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return CustomerOrders
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \AppBundle\Entity\User $updatedBy
     *
     * @return CustomerOrders
     */
    public function setUpdatedBy(\AppBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
