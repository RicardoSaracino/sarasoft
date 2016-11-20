<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Service
 *
 * @ORM\Table(name="service", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class Service
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
	 * @ORM\OneToMany(targetEntity="ServicePrice", mappedBy="service", orphanRemoval=true, cascade={"persist", "remove"})
	 *
	 * @Assert\Valid()
	 */
	private $servicePrices;

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
	 *
	 */
	public function __construct()
	{
		$this->servicePrices = new \Doctrine\Common\Collections\ArrayCollection();
	}

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
	public function getServicePrices()
	{
		return $this->servicePrices;
	}

	/**
	 * @param \AppBundle\Entity\ServicePrice $servicePrice
	 * @return $this
	 */
	public function addCustomerOrderService(\AppBundle\Entity\ServicePrice $servicePrice = null)
	{
		if (!$this->servicePrices->contains($servicePrice)) {
			$servicePrice->setService($this);
			$this->customerOrderServices->add($customerOrderService);
		}

		return $this;
	}

	/**
	 * @param string $name
	 * @return Service
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
	 * @return Service
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
