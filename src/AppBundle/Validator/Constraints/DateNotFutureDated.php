<?php
/**
 * @author Ricardo Saracino
 * @since 3/13/17
 */

namespace AppBundle\Validator\Constraints;

/**
 * Class DateNotFutureDated
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class DateNotFutureDated extends \Symfony\Component\Validator\Constraints\LessThanOrEqual
{
	public $message = 'Date should not be future dated.';

	/**
	 * @param null $options
	 */
	public function __construct($options)
	{
		parent::__construct(['value' => 'now UTC'] + $options);
	}

	/**
	 * @return string
	 */
	public function validatedBy()
	{
		return \Symfony\Component\Validator\Constraints\LessThanOrEqualValidator::class;
	}
}

