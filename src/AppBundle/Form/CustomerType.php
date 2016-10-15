<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
class CustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('firstName')
			->add('lastName')
			->add('phone', PhoneNumberType::class,array('default_region' => 'CA')) ## todo use user region?
			->add('altPhone', PhoneNumberType::class,array('default_region' => 'CA')) ## todo use user region?
			->add('email',EmailType::class)

			->add('save', SubmitType::class, ['label' => 'Save']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Customer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_customer';
    }
}
