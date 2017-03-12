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
		if (!property_exists($constraint, 'getter')) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Constraint object requires getter to be defined');
		}

		$object = $this->context->getObject();

		if (!is_callable([$object, $constraint->getter])) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Context Object does not have getter ' . $constraint->getter);
		}

		$countryCode = call_user_func([$object, $constraint->getter]);

		$addressFormatRepository = new \CommerceGuys\Addressing\Repository\AddressFormatRepository();

		$addressFormat = $addressFormatRepository->get($countryCode);

		if ($pattern = $addressFormat->getPostalCodePattern()) {

			/*
			AddressFormat {#932 ▼
			#countryCode: "CA"
			#requiredFields: array:5 [▶]
			#uppercaseFields: array:7 [▶]
			#administrativeAreaType: "province"
			#localityType: "city"
			#dependentLocalityType: null
			#postalCodeType: "postal"
			#postalCodePattern: "[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJ-NPRSTV-Z] ?\d[ABCEGHJ-NPRSTV-Z]\d"
			#postalCodePrefix: null
			#locale: "en"
			#format: """
			%recipient\n
			%organization\n
			%addressLine1\n
			%addressLine2\n
			%locality %administrativeArea %postalCode
			"""
			#usedFields: null
			#groupedFields: null
			}
			*/

			if (preg_match('!' . $pattern . '!', $value) === 0) {
				$this->context->buildViolation($constraint->message)
					->addViolation();
			}
		}
	}
}