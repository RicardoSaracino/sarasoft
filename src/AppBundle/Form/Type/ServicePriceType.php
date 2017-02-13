<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ServicePriceType
 * @package AppBundle\Form\Type
 */
class ServicePriceType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('price', \Tbbc\MoneyBundle\Form\Type\MoneyType::class, ['error_bubbling' => false, 'label' => 'servicePrice.label.price'])
			->add('effectiveFrom', DatePickerType::class, ['label' => 'servicePrice.label.effectiveFrom'])
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => \AppBundle\Entity\ServicePrice::class
		]);
	}
}