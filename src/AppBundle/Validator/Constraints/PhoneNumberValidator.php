<?php
/**
 * @author Ricardo Saracino
 * @since 3/3/17
 */

namespace AppBundle\Validator\Constraints;

/**
 * Class PhoneNumberValidator
 * @package AppBundle\Validator\Constraints
 */
class PhoneNumberValidator extends \Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumberValidator
{
	public function validate($value, \Symfony\Component\Validator\Constraint $constraint)
	{
		if (property_exists($constraint, 'getter')) {

			$object = $this->context->getObject();

			if (is_callable([$object, $constraint->getter])) {

				$constraint->defaultRegion = call_user_func([$object, $constraint->getter]);

				dump($constraint->defaultRegion);
			}
		}

		return parent::validate($value, $constraint);
	}
}