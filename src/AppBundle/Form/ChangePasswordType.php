<?php
/**
 * @author Ricardo Saracino
 * @since 10/7/16
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ChangePasswordType
 * @package AppBundle\Form
 *
 * @see http://stackoverflow.com/questions/9129784/implement-change-password-in-symfony2
 */
class ChangePasswordType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('oldPassword', 'password');
		$builder->add('newPassword', 'repeated', array(
				'type' => 'password',
				'invalid_message' => 'The password fields must match.',
				'required' => true,
				'first_options'  => array('label' => 'Password'),
				'second_options' => array('label' => 'Repeat Password'),
			));
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Acme\UserBundle\Form\Model\ChangePassword',
			));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'change_passwd';
	}
}