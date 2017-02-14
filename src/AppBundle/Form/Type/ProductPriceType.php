<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductPriceType
 * @package AppBundle\Form\Type
 */
class ProductPriceType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('price', \Tbbc\MoneyBundle\Form\Type\MoneyType::class, ['error_bubbling' => false, 'label' => 'productPrice.label.price'])
			->add('effectiveFrom', DatePickerType::class, ['label' => 'productPrice.label.effectiveFrom'])
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => \AppBundle\Entity\ProductPrice::class
		]);
	}
}