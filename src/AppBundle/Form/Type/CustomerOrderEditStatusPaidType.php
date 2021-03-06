<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderEditStatusPaidType
 * @package AppBundle\Form\Type
 */
class CustomerOrderEditStatusPaidType extends CustomerOrderType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('paidAt', UserDateTimePickerType::class, ['label' => 'customerOrder.label.paidAt'])
			->add('payment', \Tbbc\MoneyBundle\Form\Type\MoneyType::class, ['error_bubbling' => false, 'label' => 'customerOrder.label.payment'])
		;

		if ($builder->getData()->getPaymentNotes()) {
			$builder->add('paymentNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.paymentNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('paymentNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.paymentNotes', 'trim' => true]);
		}
	}
}
