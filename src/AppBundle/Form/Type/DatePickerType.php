<?php
/**
 * @author Ricardo Saracino
 * @since 10/28/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
 * Class DatePickerType
 * @package AppBundle\Form\Type
 */
class DatePickerType extends DateType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$options['attr'] = 'single_text';
		$options['format'] = 'MM/dd/yyyy';
		$options['attr'] = ['class' => 'js-datepicker', 'placeholder' => 'MM/DD/YYYY'];

		parent::buildForm($builder, $options);
	}


}