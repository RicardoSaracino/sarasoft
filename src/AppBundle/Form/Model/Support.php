<?php
/**
 * @author Ricardo Saracino
 * @since 3/11/17
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Support
 * @package AppBundle\Form\Model
 */
class Support
{
	/**
	 * @var string
	 *
	 * @Assert\NotBlank()
	 */
	protected $subject;

	/**
	 * @var string
	 *
	 * @Assert\NotBlank()
	 */
	protected $message;

	/**
	 * @var \DateTime
	 *
	 */
	protected $date;

	/**
	 * @var string
	 */
	protected $version;

	/**
	 * @var \AppBundle\Entity\User
	 */
	protected $user;

	/**
	 * @param $subject
	 * @return $this
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @param $message
	 * @return $this
	 */
	public function setMessage($message)
	{
		$this->message = $message;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param \DateTime $date
	 * @return $this
	 */
	public function setDate(\DateTime $date)
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param $version
	 * @return $this
	 */
	public function setVersion($version)
	{
		$this->version = $version;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
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
}