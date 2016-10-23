<?php
/**
 * @author Ricardo Saracino
 * @since 10/8/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Class LoginType
 * @package AppBundle\Form\Type
 */
class LoginType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username')
			->add('password', PasswordType::class);
	}
}