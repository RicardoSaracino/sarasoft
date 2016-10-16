<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StateProvinceType
 * @package AppBundle\Form\Model
 */
class StateProvinceType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
				'choices' => \AppBundle\Util\StateProvince::getOptions(),
				'choice_translation_domain' => false,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParent()
	{
		return \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'state_province';
	}


}
