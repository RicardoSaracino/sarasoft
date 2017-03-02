<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use \Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class AdministrativeAreaType
 * @package AppBundle\Form\Type
 */
class AdministrativeAreaType extends ChoiceType
{
	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
				'choices' => \AppBundle\Util\AddressHelper::getSubdivisionOptions(),
				'choice_translation_domain' => false,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParent()
	{
		return ChoiceType::class;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'administrative_are';
	}
}