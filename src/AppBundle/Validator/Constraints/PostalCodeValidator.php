<?php
/**
 * @author Ricardo Saracino
 * @since 3/2/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class PostalCodeValidator
 * @package AppBundle\Validator\Constraints
 */
class PostalCodeValidator extends ConstraintValidator
{
	/**
	 * @param mixed $value
	 * @param Constraint $constraint
	 * @throws \Symfony\Component\Validator\Exception\MappingException
	 */
	public function validate($value, Constraint $constraint)
	{
		if (!property_exists($constraint, 'field')) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Constraint object requires field to be defined');
		}

		$object = $this->context->getObject();

		$getter = 'get' . ucwords($constraint->field);

		if (!is_callable([$object, $getter])) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Context Object does not have getter ' . $getter);
		}

		$countryCode = call_user_func([$object, $getter]);

		$addressFormatRepository = new \CommerceGuys\Addressing\Repository\AddressFormatRepository();

		$addressFormat = $addressFormatRepository->get($countryCode);

		if($pattern = $addressFormat->getPostalCodePattern()){

			dump($addressFormat,preg_match('!'.$pattern.'!',$value), $pattern, $value);

			if(preg_match('!'.$pattern.'!',$value) === 0){
				$this->context->buildViolation($constraint->message)
					->addViolation();
			}
		}
	}
}