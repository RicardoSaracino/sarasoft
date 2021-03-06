<?php
/**
 * @author Ricardo Saracino
 * @since 10/7/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			#->add('oldPassword', PasswordType::class)
			->add('newPassword', RepeatedType::class, [
				'type' => PasswordType::class,
				'invalid_message' => 'The password fields must match.',
				'required' => true,
				'first_options'  => ['label' => 'user.label.newPassword'],
				'second_options' => ['label' => 'user.label.repeatPassword'],
			]);
	}
}