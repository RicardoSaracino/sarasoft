<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Type as MyType;
use AppBundle\Entity as Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class CustomerOrderType
 * @package AppBundle\Form\Type
 */
class CustomerOrderType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('company', EntityType::class, ['label' => 'customerOrder.label.company', 'class' => Entity\Company::class, 'choice_label' => 'name', 'placeholder' => 'label.choose'])
			->add('referral', EntityType::class, ['label' => 'customerOrder.label.referral', 'class' => Entity\Referral::class, 'choice_label' => 'name', 'placeholder' => 'label.choose'])
			->add('bookedFrom', MyType\UserDateTimePickerType::class, ['label' => 'customerOrder.label.bookedFrom'])
			->add('bookedUntil', MyType\UserDateTimePickerType::class, ['label' => 'customerOrder.label.bookedUntil']);

		if ($builder->getData()->getBookingNotes()) {
			$builder->add('bookingNotes', MyType\UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.bookingNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('bookingNotes', MyType\UserTextAreaType::class, ['label' => 'customerOrder.label.bookingNotes', 'trim' => true]);
		}

        $builder->add('customerOrderServices', Type\CollectionType::class, [
			'entry_type' => MyType\CustomerOrderServiceType::class,
			'label' => 'customerOrder.label.services',
			'prototype' => true,
	        'allow_add' => true,
			'allow_delete' => true,
		    'attr' => [
				'class' => 'js-collection',
			],
		]);


        $builder->add('customerOrderProducts', Type\CollectionType::class, [
			'entry_type' => MyType\CustomerOrderProductType::class,
			'label' => 'customerOrder.label.products',
			'prototype' => true,
	        'allow_add' => true,
			'allow_delete' => true,
		    'attr' => [
				'class' => 'js-collection',
			],
		]);
    }

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Entity\CustomerOrder::class
        ]);
    }
}
