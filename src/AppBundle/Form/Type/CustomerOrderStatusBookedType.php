<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class CustomerOrderStatusBookedType
 * @package AppBundle\Form\Type
 */
class CustomerOrderStatusBookedType extends CustomerOrderType
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
			->add('bookedFrom', UserDateTimePickerType::class, ['label' => 'customerOrder.label.bookedFrom'])
			->add('bookedUntil', UserDateTimePickerType::class, ['label' => 'customerOrder.label.bookedUntil']);

		if ($builder->getData()->getBookingNotes()) {
			$builder->add('bookingNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.bookingNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('bookingNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.bookingNotes', 'trim' => true]);
		}
    }
}
