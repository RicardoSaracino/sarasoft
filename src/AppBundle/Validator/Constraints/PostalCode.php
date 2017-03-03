<?php
/**
 * @author Ricardo Saracino
 * @since 3/2/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class PostalCode
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class PostalCode extends Constraint
{
	public $field = 'countryCode';

	public $message = 'This value is not a valid postal code.';
}