<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Type\StateProvinceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

/**
 * Class AddressType
 * @package AppBundle\Form\Type
 */
class AddressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('addressLine1', Type\TextType::class, ['label' => 'address.label.addressLine1'])
			->add('addressLine2', Type\TextType::class, ['label' => 'address.label.addressLine2'])
			->add('postalCode', Type\TextType::class, ['label' => 'address.label.postalCode'])
			->add('locality', Type\TextType::class, ['label' => 'address.label.locality'])
			->add('administrativeArea',AdministrativeAreaType::class, ['label' => 'address.label.administrativeArea', 'preferred_choices' => ['ON']])
			->add('countryCode',Type\CountryType::class, ['label' => 'address.label.countryCode', 'preferred_choices' => ['CA','US']])
		;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \AppBundle\Entity\Address::class
        ]);
    }
}
