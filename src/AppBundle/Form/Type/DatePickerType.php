<?php
/**
 * @author Ricardo Saracino
 * @since 10/28/16
 */

namespace AppBundle\Form\Type;

/**
 * Class DatePickerType
 * @package AppBundle\Form\Type
 */
class DatePickerType extends \Symfony\Component\Form\Extension\Core\Type\DateType
{
	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			[
				'widget' => 'single_text',
				'html5' => false,
				'compound' => false,
				'input' => null,
				'format' => 'MM/dd/yyyy',
				'model_timezone' => 'UTC',
				'view_timezone' => 'UTC',
				'attr' => ['class' => 'js-datepicker', 'placeholder' => 'MM/DD/YYYY']
			]
		);
	}

	/**
	 * @return null|string
	 */
	public function getBlockPrefix()
	{
		return 'date_picker';
	}
}