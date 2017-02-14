<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class ProductEditType
 * @package AppBundle\Form\Type
 */
class ProductEditType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', Type\TextType::class, ['label' => 'product.label.name'])
			->add('description', Type\TextType::class, ['label' => 'product.label.description'])
		;

		$builder->add(
			'productPrices',
			Type\CollectionType::class,
			[
				'entry_type' => ProductPriceType::class,
				'label' => 'product.label.productPrices',
				'by_reference' => false,
				'prototype' => false,
				'allow_add' => false,
				'allow_delete' => false,
				'disabled' => true
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => \AppBundle\Entity\Product::class
		]);
	}
}