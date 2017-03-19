<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity as Entity;

use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class CustomerOrderEditStatusBookedType
 * @package AppBundle\Form\Type
 */
class CustomerOrderEditStatusBookedType extends CustomerOrderType
{
	private $mobileDetector;

	/**
	 * @param MobileDetector $mobileDetector
	 */
	public function __construct(MobileDetector $mobileDetector)
	{
		$this->mobileDetector = $mobileDetector;
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		if($this->mobileDetector->isMobile()){
			$builder
				->add('bookedFrom', UserDateTimeType::class, ['widget' => 'single_text', 'label' => 'customerOrder.label.bookedFrom'])
				->add('bookedUntil', UserDateTimeType::class, ['widget' => 'single_text', 'label' => 'customerOrder.label.bookedUntil']);
		}
		else{
			$builder
				->add('bookedFrom', UserDateTimePickerType::class, ['label' => 'customerOrder.label.bookedFrom'])
				->add('bookedUntil', UserDateTimePickerType::class, ['label' => 'customerOrder.label.bookedUntil']);
		}


		if ($builder->getData()->getBookingNotes()) {
			$builder->add('bookingNotes', UserTextAreaPrependType::class, [
				'label' => 'customerOrder.label.bookingNotes', 'trim' => true, 'data' => $builder->getData(), 'data_class' => Entity\CustomerOrder::class]);
		} else {
			$builder->add('bookingNotes', UserTextAreaType::class, ['label' => 'customerOrder.label.bookingNotes', 'trim' => true]);
		}
    }
}
