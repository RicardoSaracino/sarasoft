<?php
/**
 * @author Ricardo Saracino
 * @since 2/16/17
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRole
 *
 * @ORM\Table(name="user_role", uniqueConstraints={@ORM\UniqueConstraint(name="user_role", columns={"user_id", "role_id"})}, indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="role_id", columns={"role_id"}), @ORM\Index(name="IDX_2DE8C6A3A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class UserRole
{
	use \AppBundle\Entity\Traits\Timestampable;

	# todo fix this
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
	 * @var \AppBundle\Entity\User
	 *
	 * The association AppBundle\Entity\UserRole#user refers to the inverse side field AppBundle\Entity\User#userRoles which does not exist.
	 *
	 * ORM\ManyToOne(targetEntity="User", inversedBy="userRoles")
	 * ORM\JoinColumns({
	 * ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 * })
	 */
	private $user;

	/**
	 * @var \AppBundle\Entity\Role
	 *
	 * @ORM\ManyToOne(targetEntity="Role", inversedBy="userRoles")
	 * @ORM\JoinColumns({
	 * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
	 * })
	 */
	private $role;

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \AppBundle\Entity\User $user
	 * @return $this
	 */
	public function setUser(\AppBundle\Entity\User $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param \AppBundle\Entity\Role $role
	 * @return $this
	 */
	public function setRole(\AppBundle\Entity\Role $role)
	{
		$this->role = $role;

		return $this;
	}

	/**
	 * @return \AppBundle\Entity\Role
	 */
	public function getRole()
	{
		return $this->role;
	}
}

