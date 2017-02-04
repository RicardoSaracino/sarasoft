<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TaxRate
 *
 * @ORM\Table(name="tax_rate", uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"code", "state_or_province", "effective_from"})}, indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxRateRepository")
 */
class TaxRate
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=32, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="state_or_province", type="string", length=32, nullable=false)
     */
    private $stateOrProvince;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="effective_from", type="date", nullable=false)
     */
    private $effectiveFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="rate", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $rate;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getRate()
	{
		return $this->rate;
	}
}

