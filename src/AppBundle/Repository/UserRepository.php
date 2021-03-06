<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
{
	/**
	 * @param string $username
	 * @return \Symfony\Component\Security\Core\User\UserInterface
	 */
	public function loadUserByUsername($username)
	{
		return $this->createQueryBuilder('u')
			->where('u.username = :username')
			->setParameter('username', $username)
			->getQuery()
			->getOneOrNullResult();
	}

	/**
	 * @param array $notRoles
	 * @return \AppBundle\Entity\User[]
	 */
	public function findByNotRoles(array $notRoles)
	{
		$qb = $this->createQueryBuilder('u');

		if ($notRoles) {
			$qb->innerJoin('AppBundle\Entity\UserRole', 'ur', 'WITH', 'u = ur.user')
				->innerJoin('AppBundle\Entity\Role', 'r', 'WITH', 'r = ur.role')
				->where($qb->expr()->notIn('r.role', ':roles'))
				->setParameter('roles', $notRoles);
		}

		return $qb->getQuery()
			->getResult();
	}
}
