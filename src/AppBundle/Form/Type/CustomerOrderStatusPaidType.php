<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderStatusPaidType
 * @package AppBundle\Form\Type
 */
class CustomerOrderStatusPaidType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('paidAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.paidAt'])
			#->add('invoiceSubtotal', \Tbbc\MoneyBundle\Form\Type\MoneyType::class, ['label' => 'customerOrder.label.invoiceSubtotal'])
		;

		if ($builder->getData()->getPaymentNotes()) {
			$builder->add('paymentNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.paymentNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('paymentNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.paymentNotes', 'trim' => true]);
		}
	}
}
