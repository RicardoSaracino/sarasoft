<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;

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
		$builder->add('username');

		if(isset($options['validation_groups']) && in_array('plain_password',$options['validation_groups'])){

			$builder->add('plainPassword', RepeatedType::class, [
				'type' => PasswordType::class,
					'invalid_message' => 'The password fields must match.',
					'required' => true,
					'first_options'  => ['label' => 'Password'],
					'second_options' => ['label' => 'Repeat Password'],
				]);
		}

		$builder
			->add('firstName')
			->add('lastName')
			->add('email',EmailType::class)
			->add('language', LanguageType::class, ['preferred_choices' => ['en','fr']])
			->add('timeZone', TimezoneType::class, ['preferred_choices' => ['America/Toronto','America/Edmonton','America/Halifax','America/Thunder_Bay','America/Vancouver']])
			->add(
				'roles', ChoiceType::class, [
					'choices' => \AppBundle\Entity\User::GetRoleOptions(),
					'expanded' => true,
					'multiple' => true,
				]
			);
	}
}