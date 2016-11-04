<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use AppBundle\Form\Type\AddressType;


/**
 * Class CompanyType
 * @package AppBundle\Form\Type
 */
class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('name')
			->add('phone', PhoneNumberType::class)
			->add('altPhone', PhoneNumberType::class)
			->add('email', EmailType::class)
			->add('address', AddressType::class,['label' => 'Address', 'compound' => true]); # todo fix label
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \AppBundle\Entity\Company::class
        ]);
    }
}
