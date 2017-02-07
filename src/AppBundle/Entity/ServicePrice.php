<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ServicePrice
 *
 * @ORM\Table(name="service_price", uniqueConstraints={@ORM\UniqueConstraint(name="service_effective_from", columns={"service_id,effective_from"})}, indexes={@ORM\Index(name="service_id", columns={"service_id"}), @ORM\Index(name="effective_from", columns={"effective_from"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicePriceRepository")
 *
 * todo UniqueEntity(
 *    fields={service_id,effective_from}
 *    errorPath="effective_from",
 *    message="This service is already effective on this date."
 * )
 */
class ServicePrice
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
	 * @var \AppBundle\Entity\Service
	 *
	 * @ORM\ManyToOne(targetEntity="Service", inversedBy="servicePrices")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
	 * })
	 */
	private $service;


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
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
}