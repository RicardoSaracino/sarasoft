<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"})})
 * @ORM\Entity
 */
class Address
{
    /**
     * @var string
     *
     * @ORM\Column(name="line_1", type="string", length=32, nullable=false)
     */
    private $line1;

    /**
     * @var string
     *
     * @ORM\Column(name="line_2", type="string", length=32, nullable=false)
     */
    private $line2;

    /**
     * @var string
     *
     * @ORM\Column(name="line_3", type="string", length=32, nullable=false)
     */
    private $line3;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=32, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_or_postalcode", type="string", length=32, nullable=false)
     */
    private $zipOrPostalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="state_or_province", type="string", length=32, nullable=false)
     */
    private $stateOrProvince;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=6, nullable=false)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * })
     */
    private $createdBy;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     * })
     */
    private $updatedBy;


}

