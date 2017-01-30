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
		$builder
			->add('invoicedAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.invoicedAt'])
			->add('invoiceSubtotal', \Tbbc\MoneyBundle\Form\Type\MoneyType::class, ['label' => 'customerOrder.label.invoiceSubtotal']);

		if ($builder->getData()->getInvoiceNotes()) {
			$builder->add('invoiceNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.invoiceNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('invoiceNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.invoiceNotes', 'trim' => true]);
		}
	}
}
