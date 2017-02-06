<?php
/**
 * @author Ricardo Saracino
 * @since 1/31/17
 */

namespace AppBundle\Entity\Traits;

use Money\Currency;
use Money\Money;

/**
 * Class Priceable
 * @package AppBundle\Entity\Traits
 */
trait Priceable
{
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="effective_from", type="date", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $effectiveFrom;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="price_amount", type="integer", nullable=false)
	 */
	private $priceAmount;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="price_currency", type="string", length=64, nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $priceCurrency;

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
	public function setPrice(Money $price)
	{
		$this->priceAmount = $price->getAmount();
		$this->priceCurrency = $price->getCurrency()->getName();

		return $this;
	}
}