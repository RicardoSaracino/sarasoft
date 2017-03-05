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
		if (!property_exists($constraint, 'getter')) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Constraint object requires getter to be defined');
		}

		$object = $this->context->getObject();

		if (!is_callable([$object, $constraint->getter])) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Context Object does not have getter ' . $constraint->getter);
		}

		$countryCode = call_user_func([$object, $constraint->getter]);

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
