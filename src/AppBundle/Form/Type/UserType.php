<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class UserType
 * @package AppBundle\Form
 */
class UserType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('username', Type\TextType::class, ['label' => 'user.label.username']);

		if(isset($options['validation_groups']) && in_array('plain_password',$options['validation_groups'])){

			$builder->add('plainPassword', Type\RepeatedType::class, [
				'type' => Type\PasswordType::class,
					'invalid_message' => 'The password fields must match.',
					'required' => true,
					'first_options'  => ['label' => 'Password'],
					'second_options' => ['label' => 'Repeat Password'],
				]);
		}

		$builder
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
					'choices' => \AppBundle\Entity\User::GetRoleOptions(),
					'expanded' => true,
					'multiple' => true,
					'label' => 'Roles'
				]
			);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => \AppBundle\Entity\User::class
        ]);
    }
}