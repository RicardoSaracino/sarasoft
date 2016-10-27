<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder
			->add('orderStatusCode')
			->add('referral', EntityType::class, ['class' => Referral::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])
			->add('bookedFrom', DateType::class, self::$DATE_ATTR)
			->add('bookedUntil', DateType::class, self::$DATE_ATTR)
			->add('startedOn', DateType::class, self::$DATE_ATTR)
			->add('finishedOn', DateType::class, self::$DATE_ATTR)
			->add('paidOn', DateType::class, self::$DATE_ATTR)
			->add('details');
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
