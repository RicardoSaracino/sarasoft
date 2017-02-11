<?php
/**
 * @author Ricardo Saracino
 * @since 2/6/17
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ProductPriceRepository
 * @package AppBundle\Repository
 */
class ServicePriceRepository extends EntityRepository
{
	/**
	 * @param \AppBundle\Entity\Service $service
	 * @param \DateTime $effectiveFrom
	 * @return \AppBundle\Entity\ServicePrice
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function findEffective(\AppBundle\Entity\Service $service, \DateTime $effectiveFrom)
	{
		$qb = $this->createQueryBuilder('sp');

		$price = $qb
			->where($qb->expr()->eq('sp.service', ':service'),$qb->expr()->lte('sp.effectiveFrom', ':effectiveFrom'))
			->setParameter('service', $service)
			->setParameter('effectiveFrom', $effectiveFrom)
			->orderBy('sp.effectiveFrom', 'DESC')
			->setMaxResults(1)
			->getQuery()
			->getSingleResult();

		if (null === $price) {
			throw new NotFoundHttpException(sprintf(
				'No Product Price Found rate available for "%s"',
				$effectiveFrom->format('Y-m-d')
			));
		}

		return $price;
	}


	/**
	 * @return \AppBundle\Entity\ServicePrice
	 */
	public function findMaxEffective()
	{
		return $this->createQueryBuilder('sp')
			->orderBy('sp.effectiveFrom', 'DESC')
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult();
	}
}