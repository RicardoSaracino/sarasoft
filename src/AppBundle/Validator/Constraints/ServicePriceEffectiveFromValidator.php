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
	 * @param \DateTime $effectiveFrom
	 * @param Constraint $constraint
	 */
	public function validate($effectiveFrom, Constraint $constraint)
	{
		/** @var \AppBundle\Repository\ServicePriceRepository $servicePriceRepository */
		$servicePriceRepository = $this->manager->getRepository('AppBundle:ServicePrice');

		/** @var \AppBundle\Entity\ServicePrice $servicePrice */
		$servicePrice = $servicePriceRepository->findMaxEffective();


		if($effectiveFrom <= $servicePrice->getEffectiveFrom()){
			$this->context->buildViolation($constraint->message)
				->setParameter('%string%', $servicePrice->getEffectiveFrom()->format('F jS, Y'))
				->addViolation();
		}
	}
}