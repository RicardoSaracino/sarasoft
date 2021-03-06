<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderEditStatusInProgressType
 * @package AppBundle\Form\Type
 */
class CustomerOrderEditStatusInProgressType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('progressStartedAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.progressStartedAt'])
			->add('progressEstimatedCompletionAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.progressEstimatedCompletionAt']);

		if ($builder->getData()->getProgressNotes()) {
			$builder->add('progressNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.progressNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('progressNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.progressNotes', 'trim' => true]);
		}

		$builder->add(
			'customerOrderServices',
			Type\CollectionType::class,
			[
				'entry_type' => CustomerOrderServiceType::class,
				'label' => 'customerOrder.label.services',
				'by_reference' => false,
				'prototype' => true,
				'allow_add' => true,
				'allow_delete' => true,
				'attr' => [
					'class' => 'js-collection',
				],
			]
		);

		$builder->add(
			'customerOrderProducts',
			Type\CollectionType::class,
			[
				'entry_type' => CustomerOrderProductType::class,
				'label' => 'customerOrder.label.products',
				'by_reference' => false,
				'prototype' => true,
				'allow_add' => true,
				'allow_delete' => true,
				'attr' => [
					'class' => 'js-collection',
				],
			]
		);
    }
}
