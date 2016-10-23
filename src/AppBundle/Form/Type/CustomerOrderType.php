<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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
			->add('orderStatusCode')
			->add('bookedFor', DateType::class,  [
				'widget' => 'single_text',
				#-'html5' => true,
				'format' => 'MM/dd/yyyy',
				'attr' => ['class' => 'js-datepicker', 'placeholder' => 'MM/DD/YYYY']
			])
			->add('startedOn')
			->add('finishedOn')
			->add('paidOn')
			->add('details');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        	'data_class' => \AppBundle\Entity\CustomerOrder::class
        ]);
    }

}
