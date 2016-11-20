<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderStatusInProgressType
 * @package AppBundle\Form\Type
 */
class CustomerOrderStatusInProgressType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('progressStartedAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.progressStartedAt']);

		if ($builder->getData()->getProgressNotes()) {
			$builder->add('progressNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.progressNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('progressNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.progressNotes', 'trim' => true]);
		}
    }
}
