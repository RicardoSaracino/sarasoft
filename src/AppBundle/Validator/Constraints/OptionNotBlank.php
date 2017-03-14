<?php
/**
 * @author Ricardo Saracino
 * @since 3/13/17
 */

namespace AppBundle\Validator\Constraints;

/**
 * Class OptionNotBlank
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class OptionNotBlank extends \Symfony\Component\Validator\Constraints\NotBlank
{
	public $message = 'Select an option.';

	/**
	 * @return string
	 */
	public function validatedBy()
	{
		return \Symfony\Component\Validator\Constraints\NotBlankValidator::class;
	}
}

