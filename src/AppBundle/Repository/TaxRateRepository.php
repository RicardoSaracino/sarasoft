<?php
/**
 * @author Ricardo Saracino
 * @since 2/2/17
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TaxRateRepository
 * @package AppBundle\Repository
 */
class TaxRateRepository extends EntityRepository
{
	/**
	 * @param \DateTime $effectiveFrom
	 * @param $stateOrProvince
	 * @return array
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function getTaxRateForDate(\DateTime $effectiveFrom, $stateOrProvince)
	{
		# http://stackoverflow.com/questions/24712889/how-to-access-repository-methods-for-an-entity-in-symfony2
		$qb = $this->createQueryBuilder('r');

		$rate = $qb
			->where($qb->expr()->lte('r.effectiveFrom', ':effectiveFrom'), $qb->expr()->eq('r.stateOrProvince', ':stateOrProvince'))
			->setParameter('effectiveFrom', $effectiveFrom)
			->setParameter('stateOrProvince', $stateOrProvince)
			->orderBy('r.effectiveFrom', 'DESC')
			->setMaxResults(1)
			->getQuery()
			->getResult();

		# todo this should be an array Quebec has weird tax (http://helpsme.com/tools/sales-tax-calculator-usa)
		if (null === $rate) {
			throw new NotFoundHttpException(sprintf(
				'No tax rate available for "%s"',
				$effectiveFrom->format('Y-m-d')
			));
		}

		return $rate;
	}
}