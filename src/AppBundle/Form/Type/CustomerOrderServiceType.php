<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CustomerOrderServiceType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('service', EntityType::class, ['class' => Service::class, 'choice_label' => 'name', 'placeholder' => 'Choose'])

			->add('quantity')

			->add('comments');
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class' => 'AppBundle\Entity\CustomerOrderService'
			)
		);
	}
}