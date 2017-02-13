<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class UserName
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class UserName extends Constraint
{
	public $message = 'This value should contain only letters or numbers or certain punctuation.';
}