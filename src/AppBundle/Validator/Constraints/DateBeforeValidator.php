<?php
/**
 * @author Ricardo Saracino
 * @since 02/10/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class DateBeforeValidator
 * @package AppBundle\Validator\Constraints
 */
class DateBeforeValidator extends ConstraintValidator
{
	/**
	 * @param \DateTime $value
	 * @param Constraint $constraint
	 * @throws \Symfony\Component\Validator\Exception\MappingException
	 */
	public function validate($value, Constraint $constraint)
	{
		if(!property_exists ($constraint,'field')){
			throw new \Symfony\Component\Validator\Exception\MappingException('Constraint object requires field to be defined');
		}

		$object = $this->context->getObject();

		$getter =  'get'.ucwords($constraint->field);

		if(!is_callable([$object,$getter])){
			throw new \Symfony\Component\Validator\Exception\MappingException('Context Object does not have getter '.$getter);
		}

		$date = call_user_func([$object,$getter]);

		if ($date instanceof \DateTime && $value instanceof \DateTime && $value && $date < $value) {
			$this->context->buildViolation($constraint->message)
				->setParameter('%date%', $date->format('F jS, Y'))
				->addViolation();
		}
	}
}