<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
		$builder

			->add('username')

			->add('password', RepeatedType::class, [
				'type' => PasswordType::class,
					'invalid_message' => 'The password fields must match.',
					'required' => true,
					'first_options'  => ['label' => 'Password'],
					'second_options' => ['label' => 'Repeat Password'],
				])

			->add('firstName')

			->add('lastName')

			->add('email')

			->add(
				'roles', ChoiceType::class, [
					'choices' => \AppBundle\Entity\User::GetRoleOptions(),
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
			'data_class' => 'AppBundle\Entity\User',
		]);
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	/*public function configureOptions(OptionsResolver $resolver)
	{
		# http://stackoverflow.com/questions/10138505/symfony2-validation-not-working-for-embedded-form-type
		# http://marcjuch.li/blog/2013/04/21/how-to-use-validation-groups-in-symfony/


		);
	}  */
}