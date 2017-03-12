<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderEditStatusInvoicedType
 * @package AppBundle\Form\Type
 */
class CustomerOrderEditStatusInvoicedType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('invoicedAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.invoicedAt'])
			->add('invoiceSubtotal', \Tbbc\MoneyBundle\Form\Type\MoneyType::class, ['disabled' => true, 'label' => 'customerOrder.label.invoiceSubtotal'])
			->add('invoiceTotal', \Tbbc\MoneyBundle\Form\Type\MoneyType::class, ['disabled' => true, 'label' => 'customerOrder.label.invoiceTotal']);

		if ($builder->getData()->getInvoiceNotes()) {
			$builder->add('invoiceNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.invoiceNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('invoiceNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.invoiceNotes', 'trim' => true]);
		}
	}
}
