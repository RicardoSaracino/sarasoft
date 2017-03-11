<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Twig;

/**
 * Class CustomerOrderExtension
 * @package AppBundle\Twig
 */
class CustomerOrderEntityManagerExtension extends \Twig_Extension
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;

	/**
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 */
	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return array
	 */
	public function getFunctions()
	{
		return [
			new \Twig_SimpleFunction('statusCounts', array($this, 'statusCountsFunction')),
		];
	}

	/**
	 * @param $status
	 * @return mixed
	 */
	public function statusCountsFunction($status)
	{
		static $statusCounts = null;

		if (is_null($statusCounts)) {
			$statusCounts = $this->entityManager->getRepository('AppBundle:CustomerOrder')->getStatusCounts();
		}

		if (array_key_exists($status, $statusCounts)) {
			return $statusCounts[$status]['statusCount'];
		}

		return null;
	}
}