<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Type as MyType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type as Type;

use AppBundle\Entity\CustomerOrder;
use AppBundle\Entity\Referral;

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
		$customerOrder = $builder->getData();

        $builder
			->add('orderStatusCode', Type\TextType::class, ['label' => 'Order Status', 'disabled' => true])
			->add('referral', EntityType::class, ['class' => Referral::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])
			->add('bookedFrom', MyType\UserDateTimePickerType::class, ['label' => 'Booked Until'])
			->add('bookedUntil', MyType\UserDateTimePickerType::class, ['label' => 'Booked Until'])
		;

		if ( $customerOrder->getBookingNotes() ) {
			$builder
				->add('originalBookingNotes', Type\TextareaType::class, ['label' => 'Booking Notes', 'disabled' => true, 'data' =>  $customerOrder->getBookingNotes(), 'mapped' => false])
				->add('bookingNotes', Type\TextareaType::class, ['label' => false, 'trim' => true, 'data' => ''])
			;
		} else {
			$builder->add('bookingNotes', Type\TextareaType::class, ['label' => 'Booking Notes', 'trim' => true]);

		}
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        	'data_class' => CustomerOrder::class
        ]);
    }
}
