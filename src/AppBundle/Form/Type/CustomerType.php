<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
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
			->add('firstName', Type\TextType::class, ['label' => 'customer.label.firstName'])
			->add('lastName', Type\TextType::class, ['label' => 'customer.label.lastName'])
			->add('phone', PhoneNumberType::class,['label' => 'customer.label.phone', 'default_region' => 'CA']) ## todo use user region?
			->add('altPhone', PhoneNumberType::class,['label' => 'customer.label.altPhone', 'default_region' => 'CA']) ## todo use user region?
			->add('email',Type\EmailType::class, ['label' => 'customer.label.email'])
			->add('address', AddressType::class,['label' => 'customer.label.homeAddress']);
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
