<?php
/**
 * @author Ricardo Saracino
 * @since 10/7/16
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ChangePassword
 * @package AppBundle\Form\Model
 */
class ChangePassword
{
	/**
	 * @var string
	 *
	 * SecurityAssert\UserPassword(
	 *     message = "Wrong value for your current password"
	 * )
	 */
	protected $oldPassword;

	/**
	 * @var string
	 *
	 * @Assert\NotBlank()
	 * @Assert\Length(
	 *     min = 8,
	 *     minMessage = "Password should by at least 8 chars long"
	 * )
	 */
	protected $newPassword;

	/**
	 * @param $oldPassword
	 * @return $this
	 */
	public function setOldPassword($oldPassword)
	{
		$this->oldPassword = $oldPassword;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOldPassword()
	{
		return $this->oldPassword;
	}

	/**
	 * @param $newPassword
	 * @return $this
	 */
	public function setNewPassword($newPassword)
	{
		$this->newPassword = $newPassword;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getNewPassword()
	{
		return $this->newPassword;
	}
}