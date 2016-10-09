<?php
/**
 * @author Ricardo Saracino
 * @since 10/8/16
 */

namespace AppBundle\Form;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;


/**
 * Class LoginType
 * @package AppBundle\Form
 */
class LoginType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username')
			->add('password', PasswordType::class);
	}
}