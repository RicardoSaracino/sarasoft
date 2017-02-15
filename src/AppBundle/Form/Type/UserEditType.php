<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserEditType
 * @package AppBundle\Form\Type
 */
class UserEditType extends UserType
{
	/**
	 * @var TokenStorage
	 */
	protected $tokenStorage;

	/**
	 * @param TokenStorage $tokenStorage
	 */
	public function __construct(TokenStorage $tokenStorage)
	{
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username', Type\TextType::class, ['label' => 'user.label.username'])
			->add('firstName', Type\TextType::class, ['label' => 'user.label.firstName'])
			->add('lastName', Type\TextType::class, ['label' => 'user.label.lastName'])
			->add('email', Type\EmailType::class, ['label' => 'user.label.email'])
			->add('language', Type\LanguageType::class, ['label' => 'user.label.language', 'preferred_choices' => ['en','fr'],'data'=>'en'])
			->add('timeZone', Type\TimezoneType::class, [
				'label' => 'user.label.timeZone',
				'preferred_choices' => ['America/Edmonton','America/Halifax','America/Thunder_Bay','America/Toronto','America/Vancouver'],
				'data'=>'America/Toronto'
			])
			->add(
				'roles', Type\ChoiceType::class, [
					'choices' => \AppBundle\Entity\User::GetRoleOptions($this->tokenStorage->getToken()->getUser()),
					'expanded' => true,
					'multiple' => true,
					'label' => 'user.label.roles'
				]
			);
	}
}