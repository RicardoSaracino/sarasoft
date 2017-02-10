<?php
/**
 * @author Ricardo Saracino
 * @since 2/8/17
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CustomerOrderRepository
 * @package AppBundle\Repository
 */
class CustomerOrderRepository extends EntityRepository
{
	/**
	 * @param \AppBundle\Entity\Customer $customer
	 * @return array
	 */
	public function findByCustomer(\AppBundle\Entity\Customer $customer)
	{
		$qb = $this->createQueryBuilder('co');

		return $qb
			->where($qb->expr()->eq('co.customer', ':customer'))
			->setParameter('customer', $customer)
			#->orderBy('sp.effectiveFrom', 'DESC')
			->getQuery()
			->getResult();
	}
}