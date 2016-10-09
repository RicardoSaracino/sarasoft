<?php
/**
 * @author Ricardo Saracino
 * @since 10/7/16
 */

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class ChangePasswordType
 *
 * @see http://stackoverflow.com/questions/9129784/implement-change-password-in-symfony2
 *
 * @package AppBundle\Form
 */
class ChangePasswordType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('oldPassword', PasswordType::class)

			->add('newPassword', RepeatedType::class, [

				'type' => PasswordType::class,
				'invalid_message' => 'The password fields must match.',
				'required' => true,
				'first_options'  => ['label' => 'Password'],
				'second_options' => ['label' => 'Repeat Password'],
			])

			->add('save', SubmitType::class, ['label' => 'Save']);
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults([
				'data_class' => 'AppBundle\Form\Model\ChangePassword',
		]);
	}
}