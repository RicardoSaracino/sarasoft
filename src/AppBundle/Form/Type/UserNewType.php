<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserNewType
 * @package AppBundle\Form\Type
 */
class UserNewType extends UserType
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
			->addPassword($builder)
			->addFirstName($builder)
			->addLastName($builder)
			->addEmail($builder)
			->addLanguage($builder)
			->addTimeZone($builder)
			->addRoles($builder);
	}
}