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
		$qb = $this->createQueryBuilder('sp');

		$price = $qb
			->where($qb->expr()->eq('sp.product', ':product'),$qb->expr()->lte('sp.effectiveFrom', ':effectiveFrom'))
			->setParameter('product', $product)
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
	 * @param \AppBundle\Entity\Product $product
	 * @return \AppBundle\Entity\ProductPrice|null
	 */
	public function findMaxEffective(\AppBundle\Entity\Product $product)
	{
		$qb = $this->createQueryBuilder('sp');

		return $qb
			->where($qb->expr()->eq('sp.product', ':product'))
			->setParameter('product', $product->getId())
			->orderBy('sp.effectiveFrom', 'DESC')
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult();
	}
}