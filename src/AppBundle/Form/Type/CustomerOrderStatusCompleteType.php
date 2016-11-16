<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderStatusCompleteType
 * @package AppBundle\Form\Type
 */
class CustomerOrderStatusCompleteType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('completedAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.completedAt']);

		if ($builder->getData()->getCompletionNotes()) {
			$builder->add('completionNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.completionNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('completionNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.completionNotes', 'trim' => true]);
		}

		$builder->add(
			'customerOrderServices',
			Type\CollectionType::class,
			[
				'entry_type' => CustomerOrderServiceType::class,
				'label' => 'customerOrder.label.services',
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
