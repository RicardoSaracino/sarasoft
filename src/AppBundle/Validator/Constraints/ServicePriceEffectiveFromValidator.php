<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

/**
 * Class ServicePriceEffectiveFromValidator
 * @package AppBundle\Validator\Constraints
 *
 */
class ServicePriceEffectiveFromValidator extends ConstraintValidator
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $manager;

	/**
	 * @param EntityManager $manager
	 */
	public function __construct(EntityManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * @param mixed $effectiveFrom
	 * @param Constraint $constraint
	 * @throws \Symfony\Component\Validator\Exception\MappingException
	 */
	public function validate($effectiveFrom, Constraint $constraint)
	{
		if (!($this->context->getObject() instanceof \AppBundle\Entity\ServicePrice)) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Context Object not instance of ServicePrice');
		}

		if(!is_null($effectiveFrom) && $effectiveFrom instanceof \DateTime) {
			throw new \Symfony\Component\Validator\Exception\MappingException('effectiveFrom not instance of DateTime or null');
		}

		/** @var \AppBundle\Repository\ServicePriceRepository $servicePriceRepository */
		$servicePriceRepository = $this->manager->getRepository('AppBundle:ServicePrice');

		/** @var \AppBundle\Entity\ServicePrice $servicePrice */
		$servicePrice = $servicePriceRepository->findMaxEffective($this->context->getObject()->getService());

		if ($servicePrice && $effectiveFrom && $effectiveFrom <= $servicePrice->getEffectiveFrom()) {
			$this->context->buildViolation($constraint->message)
				->setParameter('%date%', $servicePrice->getEffectiveFrom()->format('F jS, Y'))
				->addViolation();
		}
	}
}