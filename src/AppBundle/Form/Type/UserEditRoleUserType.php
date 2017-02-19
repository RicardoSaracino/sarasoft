<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UserEditRoleUserType
 * @package AppBundle\Form\Type
 */
class UserEditRoleUserType extends UserType
{
	protected function getRoleChoices()
	{
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$this
			->addFirstName($builder)
			->addLastName($builder)
			->addEmail($builder)
			->addLanguage($builder)
			->addTimeZone($builder);
	}
}