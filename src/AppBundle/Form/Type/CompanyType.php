<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;


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
			->add('name', Type\TextType::class, ['label' => 'company.label.name'])
			->add('phone', PhoneNumberType::class, ['label' => 'company.label.phone'])
			->add('altPhone', PhoneNumberType::class, ['label' => 'company.label.altPhone'])
			->add('email', Type\EmailType::class, ['label' => 'company.label.email'])
			->add('websiteUrl', Type\UrlType::class, ['label' => 'company.label.websiteUrl'])
			->add('facebookUrl', Type\UrlType::class, ['label' => 'company.label.facebookUrl'])
			->add('address', AddressType::class, ['label' => 'company.label.address', 'compound' => true]); # todo fix label
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
