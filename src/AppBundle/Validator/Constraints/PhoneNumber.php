<?php
/**
 * @author Ricardo Saracino
 * @since 02/10/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class PhoneNumber
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class PhoneNumber extends \Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber
{
	public $getter = 'getCountryCode';
}