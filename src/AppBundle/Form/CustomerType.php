<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;

/**
 * Class CustomerType
 * @package AppBundle\Form
 */
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
			->add('phone', PhoneNumberType::class,['default_region' => 'CA']) ## todo use user region?
			->add('altPhone', PhoneNumberType::class,['default_region' => 'CA']) ## todo use user region?
			->add('email',EmailType::class);
	}

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \AppBundle\Entity\Customer::class
        ]);
    }
}
