<?php
/**
 * @author Ricardo Saracino
 * @since 10/28/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DatePickerType
 * @package AppBundle\Form\Type
 */
class DateTimePickerType extends \Symfony\Component\Form\Extension\Core\Type\DateType
{
	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			[
				'widget' => 'single_text',
				'html5' => false,
				'compound' => false,
				'input' => null,
				'format' => 'MM/dd/yyyy hh:mm a',
				'model_timezone' => 'UTC',
				'view_timezone' => 'UTC',
				'attr' => ['class' => 'js-datetimepicker', 'placeholder' => 'MM/DD/YYYY hh:mm a']
			]
		);
	}
}