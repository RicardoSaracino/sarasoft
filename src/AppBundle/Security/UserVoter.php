<?php
/**
 * @author Ricardo Saracino
 * @since 2/18/17
 */

namespace AppBundle\Security;


use AppBundle\Entity\User;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * Class User
 * @package AppBundle\Security
 */
class UserVoter extends Voter
{
	/**
	 * @var \Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface
	 */
	private $decisionManager;

	/**
	 * @param AccessDecisionManagerInterface $decisionManager
	 */
	public function __construct(AccessDecisionManagerInterface $decisionManager)
	{
		$this->decisionManager = $decisionManager;
	}

	/**
	 * @param string $attribute
	 * @param mixed $subject
	 * @return bool|void
	 */
	protected function supports($attribute, $subject)
	{

	}

	/**
	 * @param string $attribute
	 * @param mixed $subject
	 * @param TokenInterface $token
	 * @return bool
	 */
	protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
	{
		// ...

		// ROLE_SUPER_ADMIN can do anything! The power!
		if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
			return true;
		}

		// ... all the normal voter logic
	}
}
