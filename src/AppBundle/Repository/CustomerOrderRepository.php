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
	 * @return array
	 */
	public function getStatusCounts(){

		return $this->createQueryBuilder('co')

			->select('co.status, count(1) as statusCount')

			->indexBy('co', 'co.status')

			->groupBy('co.status')

			->getQuery()

			->getResult();
	}
}