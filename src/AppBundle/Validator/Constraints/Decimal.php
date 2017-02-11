<?php
/**
 * @author Ricardo Saracino
 * @since 02/10/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Decimal
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class Decimal extends Constraint
{
	public $message = 'This value is not a proper decimal.';
}