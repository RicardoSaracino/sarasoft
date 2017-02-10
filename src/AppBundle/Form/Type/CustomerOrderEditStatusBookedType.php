<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class CustomerOrderEditStatusBookedType
 * @package AppBundle\Form\Type
 */
class CustomerOrderEditStatusBookedType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
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
