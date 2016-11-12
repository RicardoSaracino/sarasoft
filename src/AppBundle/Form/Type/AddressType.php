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
			->add('line1', Type\TextType::class, ['label' => 'address.label.line1'])
			->add('line2', Type\TextType::class, ['label' => 'address.label.line2'])
			->add('line3', Type\TextType::class, ['label' => 'address.label.line3'])
			->add('city', Type\TextType::class, ['label' => 'address.label.city'])
			->add('zipOrPostalcode', Type\TextType::class, ['label' => 'address.label.zipOrPostalcode'])
			->add('stateOrProvince',StateProvinceType::class, ['label' => 'address.label.stateOrProvince', 'preferred_choices' => ['ON']])
			->add('country',Type\CountryType::class, ['label' => 'address.label.country', 'preferred_choices' => ['CA','US']]);
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
