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
class ProductPriceRepository extends EntityRepository
{
	/**
	 * @param \AppBundle\Entity\Product $product
	 * @param \DateTime $effectiveFrom
	 * @return \AppBundle\Entity\ProductPrice
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function findEffective(\AppBundle\Entity\Product $product, \DateTime $effectiveFrom)
	{
		$qb = $this->createQueryBuilder('pp');

		$price = $qb
			->where($qb->expr()->eq('pp.product', ':product'),$qb->expr()->lte('pp.effectiveFrom', ':effectiveFrom'))
			->setParameter('product', $product)
			->setParameter('effectiveFrom', $effectiveFrom)
			->orderBy('pp.effectiveFrom', 'DESC')
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
}