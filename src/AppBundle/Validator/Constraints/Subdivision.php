<?php
/**
 * @author Ricardo Saracino
 * @since 3/1/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Subdivision
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class Subdivision extends Constraint
{
	public $getter = 'getCountryCode';

	public $message = 'This value is not a valid subdivision.';
}