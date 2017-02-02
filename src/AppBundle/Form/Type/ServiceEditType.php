<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;


/**
 * Class ServiceEditType
 * @package AppBundle\Form\Type
 */
class ServiceEditType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', Type\TextType::class, ['label' => 'service.label.name'])
			->add('description', Type\TextType::class, ['label' => 'service.label.description'])
		;

		$builder->add(
			'servicePrices',
			Type\CollectionType::class,
			[
				'entry_type' => ServicePriceType::class,
				'label' => 'service.label.servicePrices',
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
			'data_class' => \AppBundle\Entity\Service::class
		]);
	}
}