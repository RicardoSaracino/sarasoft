<?php
/**
 * @author Ricardo Saracino
 * @since 02/10/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class DateBefore
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class DateBefore extends Constraint
{
	public $field = null;

	public $message = 'This value is not dated before %date%';
}