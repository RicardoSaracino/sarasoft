<?php
/**
 * @author Ricardo Saracino
 * @since 2/4/17
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use CommerceGuys\Zone\Repository\ZoneRepositoryInterface;
use CommerceGuys\Zone\Model\ZoneInterface;

/**
 * Class ZoneRepository
 * @package AppBundle\Repository
 */
class ZoneRepository extends EntityRepository implements ZoneRepositoryInterface
{
	/**
	 * @param string $id
	 * @return \CommerceGuys\Zone\Model\ZoneInterface
	 * @throws NotFoundHttpException
	 */
	public function get($id)
	{
		throw new NotFoundHttpException(sprintf('No zone available for %s', $id));
	}

	/**
	 * @param null $scope
	 * @return \CommerceGuys\Zone\Model\ZoneInterface[]
	 * @throws NotFoundHttpException
	 */
	public function getAll($scope = null)
	{
		$qb = $this->createQueryBuilder('zone');

		$zones = $qb
			->getQuery()
			->getResult();

		if (null === $zones) {
			throw new NotFoundHttpException('No tax types available for');
		}

		return $zones;
	}
}