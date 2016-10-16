<?php
/**
 * @author Ricardo Saracino
 * @since 10/15/16
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CustomerAddressType
 *
 * @see http://elnur.pro/how-to-add-or-update-several-model-objects-at-once-with-a-single-form-in-symfony
 *
 * @package AppBundle\Form
 */
class CustomerAddressType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('customer', \AppBundle\Form\CustomerType::class)
			->add('address', \AppBundle\Form\AddressType::class);
	}
}