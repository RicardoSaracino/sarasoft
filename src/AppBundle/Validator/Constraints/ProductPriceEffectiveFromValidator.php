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
 * Class ProductPriceEffectiveFromValidator
 * @package AppBundle\Validator\Constraints
 *
 */
class ProductPriceEffectiveFromValidator extends ConstraintValidator
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
		if (!($this->context->getObject() instanceof \AppBundle\Entity\ProductPrice)) {
			throw new \Symfony\Component\Validator\Exception\MappingException('Context Object not instance of ProductPrice');
		}

		if (!is_null($effectiveFrom) && !($effectiveFrom instanceof \DateTime)) {
			throw new \Symfony\Component\Validator\Exception\MappingException('effectiveFrom not instance of DateTime or null');
		}

		/** @var \AppBundle\Repository\ProductPriceRepository $productPriceRepository */
		$productPriceRepository = $this->manager->getRepository('AppBundle:ProductPrice');

		/** @var \AppBundle\Entity\ProductPrice $productPrice */
		$productPrice = $productPriceRepository->findMaxEffective($this->context->getObject()->getProduct());

		if ($productPrice && $effectiveFrom && $effectiveFrom <= $productPrice->getEffectiveFrom()) {
			$this->context->buildViolation($constraint->message)
				->setParameter('%date%', $productPrice->getEffectiveFrom()->format('F jS, Y'))
				->addViolation();
		}
	}
}