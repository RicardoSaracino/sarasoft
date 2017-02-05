<?php
/**
 * @author Ricardo Saracino
 * @since 2/4/17
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use CommerceGuys\Zone\Repository\ZoneRepositoryInterface;

/**
 * Class ZoneRepository
 * @package AppBundle\Repository
 */
class ZoneRepository extends EntityRepository implements ZoneRepositoryInterface
{
	/**
	 * @param string $id
	 * @return \CommerceGuys\Zone\Repository\ZoneInterface
	 * @throws NotFoundHttpException
	 */
	public function get($id)
	{
		throw new NotFoundHttpException(sprintf('No zone available for %s', $id));
	}

	/**
	 * @param null $scope
	 * @return \CommerceGuys\Zone\Repository\ZoneInterface[]
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

		foreach ($zones as $zone) {

			## todo this a fucking mess
			$zone->setMembers(new \Doctrine\Common\Collections\ArrayCollection());
			$zoneMemberCanadaOntario = new \CommerceGuys\Zone\Model\ZoneMemberCountry();
			$zoneMemberCanadaOntario->setCountryCode('CA');
			$zoneMemberCanadaOntario->setAdministrativeArea('ON');
			$zone->addMember($zoneMemberCanadaOntario);
		}

		return $zones;
	}
}