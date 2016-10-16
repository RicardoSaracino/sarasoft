<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ContainsAlphanumericValidator
 * @package AppBundle\Validator\Constraints
 */
class ContainsAlphanumericValidator extends ConstraintValidator
{
	/**
	 * @param mixed $value
	 * @param Constraint $constraint
	 */
	public function validate($value, Constraint $constraint)
	{
		if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
			$this->context->buildViolation($constraint->message)
				#->setParameter('%string%', $value)
				->addViolation();
		}
	}
}