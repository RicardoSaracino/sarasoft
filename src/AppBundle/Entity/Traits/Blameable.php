<?php
/**
 * @author Ricardo Saracino
 * @since 10/28/16
 */

namespace AppBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Blameable
 * @package AppBundle\Entity\Traits
 */
trait Blameable
{
	/**
	 * @var \AppBundle\Entity\User
	 *
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
	 * })
	 *
	 * @Gedmo\Blameable(on="create")
	 */
	private $createdBy;

	/**
	 * @var \AppBundle\Entity\User
	 *
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
	 * })
	 *
	 * @Gedmo\Blameable(on="update")
	 */
	private $updatedBy;

	/**
	 * @return \AppBundle\Entity\User
	 */
	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	/**
	 * @return \DateTime

	public function getUpdatedAt()
	{
	return $this->updatedAt;
	}*/

	/**
	 * @return \AppBundle\Entity\User
	 */
	public function getUpdatedBy()
	{
		return $this->updatedBy;
	}
}