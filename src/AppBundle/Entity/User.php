<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Intl\Intl;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @UniqueEntity("username",groups={"new","edit"})
 * @UniqueEntity("email",groups={"new","edit"})
 */
class User implements UserInterface, \Serializable
{
	use \AppBundle\Entity\Traits\Timestampable;
	use \AppBundle\Entity\Traits\Blameable;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection|\AppBundle\Entity\Role[]
	 *
	 * @ORM\ManyToMany(targetEntity="Role", fetch="EAGER", orphanRemoval=true, cascade={"persist", "remove"})
	 *
	 * @Assert\NotBlank(message="Select an option.", groups={"new","edit"})
	 */
	private $roles;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="username", type="string", length=32, unique=true)
	 *
	 * @Assert\Length(min=5, max=32, groups={"new","edit"})
	 * @AppAssert\UserName(groups={"new","edit"})
	 */
	private $username;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=60)
	 */
	private $password;

	/**
	 * @var string
	 *
	 * @Assert\NotBlank(groups={"new"})
	 * @Assert\Length(min=8, groups={"new"})
	 */
	private $plainPassword;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="salt", type="string", length=60)
	 */
	private $salt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="first_name", type="string", length=32)
	 *
	 * @Assert\NotBlank(groups={"new","edit"})
	 * @Assert\Length(min=3, max=32, groups={"new","edit"})
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="last_name", type="string", length=32)
	 *
	 * @Assert\NotBlank(groups={"new","edit"})
	 * @Assert\Length(min=3, max=32, groups={"new","edit"})
	 */
	private $lastName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=64)
	 *
	 * @Assert\NotBlank(groups={"new","edit"})
	 * @Assert\Email(groups={"new","edit"})
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="language", type="string", length=16)
	 *
	 * @Assert\Language(groups={"new","edit"})
	 */
	private $language;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="time_zone", type="string", length=32)
	 *
	 * @Assert\NotBlank(groups={"new","edit"})
	 */
	private $timeZone;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_password_at", type="datetime", nullable=true)
	 *
	 * @Gedmo\Timestampable(on="change", field={"password"})
	 */
	private $updatedPasswordAt;

	/**
	 * @return bool
	 *
	 * @Assert\IsTrue(message="The password cannot match your username", groups={"plain_password"})
	 */
	public function isPasswordLegal()
	{
		return ($this->username !== $this->plainPassword);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Lower cases on set
	 *
	 * @param string $username
	 *
	 * @return User
	 */
	public function setUsername($username)
	{
		$this->username = mb_strtolower($username);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * @see Symfony\Component\Security\Core\User\UserInterface
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param $plainPassword
	 * @return $this
	 */
	public function setPlainPassword($plainPassword)
	{
		$this->plainPassword = $plainPassword;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	/**
	 * @param $salt
	 * @return $this
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;

		return $this;
	}

	/**
	 * @see Symfony\Component\Security\Core\User\UserInterface
	 *
	 * @return string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	####################################################

	/**
	 * @param \AppBundle\Entity\Role[] $roles
	 * @return $this
	 */
	public function setRoles($roles)
	{
		$this->roles = $roles;
		return $this;
	}

	/**
	 * @param \AppBundle\Entity\Role[] $roles
	 * @return $this
	 */
	public function addRole($roles)
	{
	   	$this->roles->add($roles);
		return $this;
	}

	/**
	 * @see Symfony\Component\Security\Core\User\UserInterface
	 *
	 * @return array
	 */
	public function getRoles()
	{
		if($this->roles){
			return $this->roles->getValues();
		}

		return [];
	}

	/**
	 * @return bool
	 */
	public function hasAdminRole()
	{
		foreach($this->roles as $role){
			if($role->getRole() == 'ROLE_SUPER_ADMIN' || $role->getRole() == 'ROLE_ADMIN')
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function hasSuperAdminRole()
	{
		foreach($this->roles as $role){
			if($role->getRole() == 'ROLE_SUPER_ADMIN')
			{
				return true;
			}
		}

		return false;
	}

	####################################################

	/**
	 * @param $firstName
	 * @return $this
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * @param $lastName
	 * @return $this
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * @return string
	 */
	public function getFullName()
	{
		return $this->firstName . ' ' . $this->lastName;
	}

	/**
	 * Lower cases on set
	 *
	 * @param $email
	 * @return $this
	 */
	public function setEmail($email)
	{
		$this->email = mb_strtolower($email);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param $language
	 * @return $this
	 */
	public function setLanguage($language)
	{
		$this->language = $language;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * @param $timeZone
	 * @return $this
	 */
	public function setTimeZone($timeZone)
	{
		$this->timeZone = $timeZone;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTimeZone()
	{
		return $this->timeZone;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedPasswordAt()
	{
		return $this->updatedPasswordAt;
	}

	##########

	/**
	 * @see Symfony\Component\Security\Core\User\UserInterface
	 */
	public function eraseCredentials()
	{
	}

	/**
	 * @see \Serializable::serialize()
	 *
	 * @return string
	 */
	public function serialize()
	{
		return serialize(
			array(
				$this->id,
				$this->username,
				$this->password,
				// see section on salt below
				// $this->salt,
			)
		);
	}

	/**
	 * @see \Serializable::unserialize()
	 *
	 * @param string $serialized
	 */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
			// see section on salt below
			// $this->salt
			) = unserialize($serialized);
	}

	/**
	 * @return null|string
	 */
	public function getLanguageName()
	{
		return Intl::getLocaleBundle()->getLocaleName($this->language);
	}
}
