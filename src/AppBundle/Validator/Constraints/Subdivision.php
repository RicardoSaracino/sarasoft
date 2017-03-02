<?php
/**
 * @author Ricardo Saracino
 * @since 3/1/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class UserName
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class Subdivision extends Constraint
{
	public $field = null;

	public $message = 'This value is not a valid subdivision.';
}