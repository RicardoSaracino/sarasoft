<?php

namespace AppBundle\Form\Type;

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
	private static $DATE_ATTR = [
		'widget' => 'single_text',
		#-'html5' => true,
		'format' => 'MM/dd/yyyy',
		'attr' => ['class' => 'js-datepicker', 'placeholder' => 'MM/DD/YYYY']
	];

	private static $DATETIME_ATTR = [
		'widget' => 'single_text',
		#-'html5' => true,
		'format' => 'MM/dd/yyyy hh:mm a',
		'model_timezone' => 'UTC',
		'view_timezone' => 'America/Toronto',
		'attr' => ['class' => 'js-datetimepicker', 'placeholder' => 'MM/DD/YYYY hh:mm a']
	];

	/**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$customerOrder = $builder->getData();

        $builder
			->add('orderStatusCode', Type\TextType::class, ['label' => 'Order Status', 'disabled' => true])
			->add('referral', EntityType::class, ['class' => Referral::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])
			->add('bookedFrom', Type\DateType::class, self::$DATETIME_ATTR + ['label' => 'Booked From'])
			->add('bookedUntil', Type\DateType::class, self::$DATETIME_ATTR + ['label' => 'Booked Until'])
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
