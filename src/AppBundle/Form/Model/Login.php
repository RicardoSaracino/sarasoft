<?php
/**
 * @author Ricardo Saracino
 * @since 10/7/16
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Login
 * @package AppBundle\Form\Model
 */
class Login
{
	/**
	 * @var string
	 *
	 * @Assert\NotBlank()
	 */
	protected $username;

	/**
	 * @var string
	 *
	 * @Assert\NotBlank()
	 */
	protected $password;


	/**
	 * @param $username
	 * @return $this
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
	 * @param $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}
}