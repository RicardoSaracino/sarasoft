<?php
/**
 * @author Ricardo Saracino
 * @since 10/20/16
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class EntityHiddenType
 * @package AppBundle\Form\Model
 */
class EntityHiddenType extends \Symfony\Component\Form\Extension\Core\Type\HiddenType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addModelTransformer(new \AppBundle\Form\Transformer\EntityToIdTransformer($options['data']));
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => null,
			'property_path' => 'getId'
		]);
	}
}