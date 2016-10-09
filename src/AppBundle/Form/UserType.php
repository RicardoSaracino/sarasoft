<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
			->add('firstName')
			->add('lastName')
			->add('email')
			#->add('password'), part of validation group "password"
			->add(
				'roles', ChoiceType::class, [
					'choices' => \AppBundle\Entity\User::GetRoleOptions(),
					'expanded' => true,
					'multiple' => true,
				]
			);
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		# http://stackoverflow.com/questions/10138505/symfony2-validation-not-working-for-embedded-form-type
		# http://marcjuch.li/blog/2013/04/21/how-to-use-validation-groups-in-symfony/

		$resolver->setDefaults([
				'data_class' => 'AppBundle\Entity\User',
				#'validation_groups' => array('Default')
			]
		);
	}
}