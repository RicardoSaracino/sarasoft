<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderStatusInvoicedType
 * @package AppBundle\Form\Type
 */
class CustomerOrderStatusInvoicedType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('invoicedAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.invoicedAt']);

		if ($builder->getData()->getCompletionNotes()) {
			$builder->add('invoiceNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.invoiceNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('completionNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.invoiceNotes', 'trim' => true]);
		}
	}
}
