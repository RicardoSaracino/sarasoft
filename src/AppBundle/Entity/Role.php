<?php
/**
 * @author Ricardo Saracino
 * @since 2/16/17
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role", indexes={@ORM\Index(name="updated_by", columns={"updated_by"}), @ORM\Index(name="created_by", columns={"created_by"})})
 * @ORM\Entity
 */
class Role implements \Symfony\Component\Security\Core\Role\RoleInterface
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
	 * @var \Doctrine\Common\Collections\ArrayCollection|\AppBundle\Entity\UserRole[]
	 *
	 * @ORM\OneToMany(targetEntity="UserRole", mappedBy="role", fetch="EAGER", orphanRemoval=true, cascade={"persist", "remove"})
	 */
	private $userRoles;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=64, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="role", type="string", length=64, nullable=false)
	 */
	private $role;

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param $name
	 * @return $this
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
	 * @param $role
	 * @return $this
	 */
	public function setRole($role)
	{
		$this->role = $role;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getRole()
	{
		return $this->role;
	}
}
