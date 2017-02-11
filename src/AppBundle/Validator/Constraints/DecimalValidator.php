<?php
/**
 * @author Ricardo Saracino
 * @since 02/10/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class DecimalValidator
 * @package AppBundle\Validator\Constraints
 */
class DecimalValidator extends ConstraintValidator
{
	/**
	 * @param mixed $value
	 * @param Constraint $constraint
	 */
	public function validate($value, Constraint $constraint)
	{
		if (preg_match('/[0-9]+(\.[0-9][0-9]?)?/', $value) === 0) {
			$this->context->buildViolation($constraint->message)
				->addViolation();
		}
	}
}