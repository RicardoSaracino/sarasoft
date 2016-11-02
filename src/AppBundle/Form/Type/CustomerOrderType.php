<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Type as MyType;
use AppBundle\Entity\CustomerOrder;
use AppBundle\Entity\Company;
use AppBundle\Entity\Referral;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
        $builder
			->add('orderStatusCode', Type\TextType::class, ['label' => 'Order Status', 'disabled' => true])
			->add('company', EntityType::class, ['class' => Company::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])
			->add('referral', EntityType::class, ['class' => Referral::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])
			->add('bookedFrom', MyType\UserDateTimePickerType::class, ['label' => 'Booked From'])
			->add('bookedUntil', MyType\UserDateTimePickerType::class, ['label' => 'Booked Until']);


		if($builder->getData()->getBookingNotes())
		{
			$builder->add('bookingNotes', MyType\UserTextAreaPrependType::class, ['label' => 'Booking Notes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => CustomerOrder::class]);
		}
		else
		{
			$builder->add('bookingNotes', MyType\UserTextAreaType::class, ['label' => 'Booking Notes', 'trim' => true]);
		}


        $builder->add('customerOrderServices', Type\CollectionType::class, array(
		'entry_type' => CustomerOrderService::class
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
