<?php
/**
 * @author Ricardo Saracino
 * @since 2/2/17
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use CommerceGuys\Tax\Repository\TaxTypeRepositoryInterface;

/**
 * Class TaxRateRepository
 * @package AppBundle\Repository
 */
class TaxTypeRepository extends EntityRepository implements TaxTypeRepositoryInterface
{
	/**
	 * @param string $id
	 * @return \CommerceGuys\Tax\Repository\TaxTypeInterface
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function get($id)
	{
		throw new NotFoundHttpException(sprintf('No tax type available for %s', $id));
	}

	/**
	 * @return \CommerceGuys\Tax\Repository\TaxTypeInterface[]
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function getAll()
	{
		static $taxTypes = null;

		if(!is_null($taxTypes)){
			return $taxTypes;
		}

		$taxTypes = $this->createQueryBuilder('t')
			->getQuery()
			->getResult();

		if (null === $taxTypes) {
			throw new NotFoundHttpException('No tax types available for');
		}

		return $taxTypes;
	}
}