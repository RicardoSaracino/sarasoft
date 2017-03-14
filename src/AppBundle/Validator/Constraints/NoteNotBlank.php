<?php
/**
 * @author Ricardo Saracino
 * @since 3/13/17
 */

namespace AppBundle\Validator\Constraints;

/**
 * Class NoteNotBlank
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class NoteNotBlank extends \Symfony\Component\Validator\Constraints\NotBlank
{
	public $message = 'Note should not be blank.';

	/**
	 * @return string
	 */
	public function validatedBy()
	{
		return \Symfony\Component\Validator\Constraints\NotBlankValidator::class;
	}
}
