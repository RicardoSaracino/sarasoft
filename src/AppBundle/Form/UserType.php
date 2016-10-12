<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class UserType
 * @package AppBundle\Form
 */
class UserType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
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
			->add('email')
			->add('language', LanguageType::class)
			->add('timeZone', TimezoneType::class)
			->add(
				'roles', ChoiceType::class, [
					'choices' => User::GetRoleOptions(),
					'expanded' => true,
					'multiple' => true,
				]
			)
			->add('save', SubmitType::class, ['label' => 'Save']);
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}
}