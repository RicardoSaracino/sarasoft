<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderEditStatusCancelledType
 * @package AppBundle\Form\Type
 */
class CustomerOrderEditStatusCancelledType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('cancelledAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.cancelledAt']);

		if ($builder->getData()->getCancellationNotes()) {
			$builder->add('cancellationNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.cancellationNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('cancellationNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.cancellationNotes', 'trim' => true]);
		}
    }
}
