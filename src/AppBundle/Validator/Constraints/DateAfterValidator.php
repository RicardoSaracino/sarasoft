<?php
/**
 * @author Ricardo Saracino
 * @since 02/10/17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class DateAfterValidator
 * @package AppBundle\Validator\Constraints
 */
class DateAfterValidator extends ConstraintValidator
{
	/**
	 * @var TokenStorage
	 */
	protected $tokenStorage;

	/**
	 * @param TokenStorage $tokenStorage
	 */
	public function __construct(TokenStorage $tokenStorage)
	{
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->tokenStorage->getToken()->getUser();
	}

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

		if(!is_null($value) && !($value instanceof \DateTime)) {
			throw new \Symfony\Component\Validator\Exception\MappingException('value not instance of DateTime or null');
		}

		$object = $this->context->getObject();

		$getter =  'get'.ucwords($constraint->field);

		if(!is_callable([$object,$getter])){
			throw new \Symfony\Component\Validator\Exception\MappingException('Context Object does not have getter '.$getter);
		}

		$date = call_user_func([$object,$getter]);

		if(!is_null($date) && !($date instanceof \DateTime)) {
			throw new \Symfony\Component\Validator\Exception\MappingException($constraint->field.' not instance of DateTime or null');
		}

		if ($date && $value && $date > $value) {
			$this->context->buildViolation($constraint->message)
				->setParameter('%date%', $date->setTimezone(new \DateTimeZone($this->getUser()->getTimeZone()))->format('F jS, Y g:i A'))
				->addViolation();
		}
	}
}