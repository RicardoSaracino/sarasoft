<?php

namespace AppBundle\Form\Type;

use Doctrine\Bundle\DoctrineBundle\Tests\Builder\BundleConfigurationBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserEditType
 * @package AppBundle\Form\Type
 */
class UserEditType extends UserType
{
	/**
	 * @var \AppBundle\Entity\User
	 */
	protected $user;

	/**
	 * @var \AppBundle\Util\RoleHelper
	 */
	protected $roleHelper;

	/**
	 * @param TokenStorage $tokenStorage
	 * @param \AppBundle\Util\RoleHelper $roleHelper
	 */
	public function __construct(TokenStorage $tokenStorage, \AppBundle\Util\RoleHelper $roleHelper)
	{
		$this->user = $tokenStorage->getToken()->getUser();

		$this->roleHelper = $roleHelper;
	}

	/**
	 * @return \AppBundle\Entity\Role[]
	 */
	protected function getRoleChoices()
	{
		return $this->roleHelper->getUserAllRoles($this->user);
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$this
			->addUsername($builder)
			->addFirstName($builder)
			->addLastName($builder)
			->addEmail($builder)
			->addLanguage($builder)
			->addTimeZone($builder)
			->addRoles($builder);
	}
}