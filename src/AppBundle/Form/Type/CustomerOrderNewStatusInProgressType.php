<?php
/**
 * @author Ricardo Saracino
 * @since 2/8/17
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class CustomerOrderNewStatusInProgressType
 * @package AppBundle\Form\Type
 */
class CustomerOrderNewStatusInProgressType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('company', EntityType::class, ['label' => 'customerOrder.label.company', 'class' => Entity\Company::class, 'choice_label' => 'name', 'placeholder' => 'label.choose'])
			->add('orderType', EntityType::class, ['label' => 'customerOrder.label.orderType', 'class' => Entity\OrderType::class, 'choice_label' => 'name', 'placeholder' => 'label.choose'])
			->add('referral', EntityType::class, ['label' => 'customerOrder.label.referral', 'class' => Entity\Referral::class, 'choice_label' => 'name', 'placeholder' => 'label.choose'])

			->add('progressStartedAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.progressStartedAt'])
			->add('progressEstimatedCompletionAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.progressEstimatedCompletionAt'])
			->add('progressNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.progressNotes', 'trim' => true]);

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
