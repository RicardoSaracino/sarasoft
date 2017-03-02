<?php
/**
 * @author Ricardo Saracino
 * @since 3/1/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class SubdivisionValidator
 * @package AppBundle\Validator\Constraints
 */
class SubdivisionValidator extends ConstraintValidator
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

		$subdivisionRepository = new \CommerceGuys\Addressing\Repository\SubdivisionRepository();

		/*Subdivision {#961 ▼
		#parent: null
		#countryCode: "CA"
		#id: "CA-ON"
		#code: "ON"
		#name: "Ontario"
		#postalCodePattern: "K|L|M|N|P"
		#postalCodePatternType: "start"
		#children: ArrayCollection {#964 ▶}
		#locale: "en"
		}*/

		$subdivision = $subdivisionRepository->get($value);

		if (!$subdivision || $subdivision->getCountryCode() != $countryCode) {
			$this->context->buildViolation($constraint->message)
				->addViolation();
		}
	}
}
