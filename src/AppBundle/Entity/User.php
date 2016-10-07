<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @see http://symfony.com/doc/current/security/entity_provider.html
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="username", type="string", length=32, unique=true)
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
	 * @ORM\Column(name="first_name", type="string", length=32)
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="last_name", type="string", length=32)
	 */
	private $lastName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=64)
	 */
	private $email;


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $username
	 *
	 * @return User
	 */
	public function setUsername($username)
	{
		$this->username = $username;

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
	 * @param $email
	 * @return $this
	 */
	public function setEmail($email)
	{
		$this->email = $email;

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
	 * @param string $password
	 *
	 * @return User
	 */
	public function setPassword($password)
	{
		/*$options = [
			'cost' => 12,
		];
		echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options);*/


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
	 * @see Symfony\Component\Security\Core\User\UserInterface
	 *
	 * @return array
	 */
	public function getRoles()
	{
		return array('ROLE_USER');
	}

	/**
	 * @see Symfony\Component\Security\Core\User\UserInterface
	 *
	 * @return null
	 */
	public function getSalt()
	{
		// you *may* need a real salt depending on your encoder
		// see section on salt below
		return null;
	}

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
}