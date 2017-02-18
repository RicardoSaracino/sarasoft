<?php
/**
 * @author Ricardo Saracino
 * @since 2/17/17
 */

namespace AppBundle\Util;

use Doctrine\ORM\EntityManager;

/**
 * Class RoleHelper
 * @package AppBundle\Util
 *
 * http://stackoverflow.com/questions/11246774/symfony2-getting-the-list-of-user-roles-in-formbuilder
 * http://stackoverflow.com/questions/11246774/symfony2-getting-the-list-of-user-roles-in-formbuilder/36900807#36900807
 */
class RoleHelper
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $manager;

	/**
	 * @var array
	 */
	private $rolesHierarchy;

	/**
	 * @var array
	 */
	private $roles;

	/**
	 * @param array $rolesHierarchy
	 * @param EntityManager $manager
	 */
	public function __construct(array $rolesHierarchy, EntityManager $manager)
	{
		$this->rolesHierarchy = $rolesHierarchy;

		$this->manager = $manager;
	}

	/**
	 * @param \AppBundle\Entity\User $user
	 * @return \AppBundle\Entity\Role[]
	 */
	public function getUserAllRoles(\AppBundle\Entity\User $user)
	{
		$roles = array_merge($user->getRoles(), $this->getUserInheritedRoles($user));

		$uniqueRoles = array_unique($roles);

		#todo list priority
		usort($uniqueRoles,function($a, $b){return $a->getId() - $b->getId();});

		return $uniqueRoles;
	}

	/**
	 * @param \AppBundle\Entity\User $user
	 * @return \AppBundle\Entity\Role[]
	 */
	public function getUserInheritedRoles(\AppBundle\Entity\User $user)
	{
		$roles = [];

		foreach( $user->getRoles() as $role ){
			$roles = array_merge($roles, $this->getRoleInheritedRoles($role));
		}

		$uniqueRoles = array_unique($roles);

		#todo list priority
		usort($uniqueRoles,function($a, $b){return $a->getId() - $b->getId();});

		return $uniqueRoles;
	}

	/**
	 * @param \AppBundle\Entity\Role $role
	 * @return array
	 */
	public function getRoleInheritedRoles(\AppBundle\Entity\Role $role)
	{
		$strRoles = $this->getRolesHelper();

		if (array_key_exists($role->getRole(), $strRoles)) {

			/** @var \AppBundle\Entity\Role[] $allRoles */
			$allRoles = $this->manager->getRepository('AppBundle:Role')->findAll();

			$roles = [];

			foreach ($allRoles as $_role) {
				if (array_key_exists($_role->getRole(), $strRoles[$role->getRole()])) {
					$roles[] = $_role;
				}
			}

			return $roles;
		}

		return [];
	}

	#########

	/**
	 * @return array
	 */
	private function getRolesHelper()
	{
		if ($this->roles) {
			return $this->roles;
		}

		$roles = array();

		/**
		 * Get all unique roles
		 */
		foreach ($this->rolesHierarchy as $originalRole => $inheritedRoles) {
			foreach ($inheritedRoles as $inheritedRole) {
				$roles[$inheritedRole] = array();
			}

			$roles[$originalRole] = array();
		}

		/**
		 * Get all inherited roles from the unique roles
		 */
		foreach ($roles as $key => $role) {
			$roles[$key] = $this->getInheritedRolesHelper($key, $this->rolesHierarchy);
		}

		return $this->roles = $roles;
	}

	/**
	 * @param $role
	 * @param $originalRoles
	 * @param array $roles
	 * @return array
	 */
	private function getInheritedRolesHelper($role, $originalRoles, $roles = array())
	{
		/**
		 * If the role is not in the originalRoles array,
		 * the role inherit no other roles.
		 */
		if (!array_key_exists($role, $originalRoles)) {
			return $roles;
		}

		/**
		 * Add all inherited roles to the roles array
		 */
		foreach ($originalRoles[$role] as $inheritedRole) {
			$roles[$inheritedRole] = $inheritedRole;
		}

		/**
		 * Check for each inhered role for other inherited roles
		 */
		foreach ($originalRoles[$role] as $inheritedRole) {
			return $this->getInheritedRolesHelper($inheritedRole, $originalRoles, $roles);
		}

		return [];
	}
}