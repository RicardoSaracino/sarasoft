<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type as MyType;
use AppBundle\Entity\CustomerOrder;
use AppBundle\Entity\Company;
use AppBundle\Entity\Referral;

use Symfony\Component\Form\CallbackTransformer;


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
			->add('company', EntityType::class, ['class' => Company::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])
			->add('referral', EntityType::class, ['class' => Referral::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])
			->add('bookedFrom', MyType\UserDateTimePickerType::class, ['label' => 'Booked From'])
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


		$builder->get('bookingNotes')
			->addModelTransformer(new CallbackTransformer(
					function ($notes) {
						// transform the array to a string
						return $notes;
					},
					function ($notes) {
						// transform the string back to an array
						return 'USER NAME & Time ' . $notes;
					}
				));
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
