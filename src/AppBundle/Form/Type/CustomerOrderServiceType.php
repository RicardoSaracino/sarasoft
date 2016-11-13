<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CustomerOrderServiceType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('service', EntityType::class, ['label' => 'customerOrderService.label.service', 'class' => Service::class, 'choice_label' => 'name', 'placeholder' => 'label.choose'])
			->add('quantity', Type\IntegerType::class, ['label' => 'customerOrderService.label.quantity',
				'data' => '1',
				'attr' => [
					'min' => 1,
				]])
			->add('comments', Type\TextType::class, ['label' => 'customerOrderService.label.comments']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => \AppBundle\Entity\CustomerOrderService::class
		]);
	}
}
