<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as AppAssert;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Money\Currency;
use Money\Money;

/**
 * ServicePrice
 *
 * @ORM\Table(name="service_price", uniqueConstraints={@ORM\UniqueConstraint(name="service_effective_from", columns={"service_id,effective_from"})}, indexes={@ORM\Index(name="service_id", columns={"service_id"}), @ORM\Index(name="effective_from", columns={"effective_from"}), @ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicePriceRepository")
 */
class ServicePrice
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
	 * @var \AppBundle\Entity\Service
	 *
	 * @ORM\ManyToOne(targetEntity="Service", inversedBy="servicePrices")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
	 * })
	 */
	private $service;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="effective_from", type="date", nullable=false)
	 *
	 * @Assert\NotBlank()
	 *
	 * @AppAssert\ServicePriceEffectiveFrom()
	 */
	private $effectiveFrom;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="price_amount", type="integer", nullable=false)
	 *
	 * @AppAssert\Decimal(message="Price is not a proper decimal")
	 */
	private $priceAmount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="price_currency", type="string", length=64, nullable=false)
	 */
	private $priceCurrency = 'CAD';

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

	/**
	 * @param $effectiveFrom
	 * @return $this
	 */
	public function setEffectiveFrom($effectiveFrom)
	{
		$this->effectiveFrom = $effectiveFrom;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getEffectiveFrom()
	{
		return $this->effectiveFrom;
	}

	/**
	 * @return Money|null
	 */
	public function getPrice()
	{
		if (!$this->priceCurrency) {
			return null;
		}
		if (!$this->priceAmount) {
			return new Money(0, new Currency($this->priceCurrency));
		}

		return new Money($this->priceAmount, new Currency($this->priceCurrency));
	}

	/**
	 * @param Money $price
	 * @return $this
	 */
	public function setPrice(Money $price = null)
	{
		if (!is_null($price)) {

			$this->priceAmount = $price->getAmount();
			$this->priceCurrency = $price->getCurrency()->getCode();
		}

		return $this;
	}
}