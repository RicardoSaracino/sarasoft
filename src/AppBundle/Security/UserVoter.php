<?php
/**
 * @author Ricardo Saracino
 * @since 2/18/17
 */

namespace AppBundle\Security;


use AppBundle\Entity\User;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * Class User
 * @package AppBundle\Security
 */
class UserVoter extends Voter
{
	const VIEW = 'VOTER_USER_VIEW';
	const EDIT = 'VOTER_USER_EDIT';

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
		# if the attribute isn't one we support, return false
		if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
			return false;
		}

		# only vote on Users objects inside this voter
		if (!$subject instanceof User) {
			return false;
		}

		return true;
	}

	/**
	 * @param string $attribute
	 * @param mixed $subject
	 * @param TokenInterface $token
	 * @return bool
	 * @throws \LogicException
	 */
	protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
	{
		if (!$token->getUser() instanceof User) {
			# the user must be logged in; if not, deny access
			return false;
		}

		if ($this->decisionManager->decide($token, ['ROLE_SUPER_ADMIN'])) {
			return true;
		}

		/** @var User $post */
		$user = $subject;

		switch ($attribute) {
			case self::VIEW:
				return $this->canView($user, $token);
			case self::EDIT:
				return $this->canEdit($user, $token);
		}

		throw new \LogicException('This code should not be reached!');
	}

	/**
	 * @param User $user
	 * @param TokenInterface $token
	 * @return bool
	 * @throws \LogicException
	 */
	public function canView(User $user, TokenInterface $token)
	{
		if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {

			return ! $this->decisionManager->decide(new UsernamePasswordToken($user, 'none', 'none', $user->getRoles()), ['ROLE_SUPER_ADMIN']);
		}

		if ($this->decisionManager->decide($token, ['ROLE_USER'])) {

			return $user->getId() == $token->getUser()->getId();
		}

		throw new \LogicException('This code should not be reached!');
	}

	/**
	 * @param User $user
	 * @param TokenInterface $token
	 * @return bool
	 * @throws \LogicException
	 */
	public function canEdit(User $user, TokenInterface $token)
	{
		if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {

			return ! $this->decisionManager->decide(new UsernamePasswordToken($user, 'none', 'none', $user->getRoles()), ['ROLE_SUPER_ADMIN']);
		}

		if ($this->decisionManager->decide($token, ['ROLE_USER'])) {

			return $user->getId() == $token->getUser()->getId();
		}

		throw new \LogicException('This code should not be reached!');
	}
}
