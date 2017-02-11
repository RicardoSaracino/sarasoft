<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsAlphanumeric
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint
{
	public $message = 'The value should contain only letters or numbers.';
}