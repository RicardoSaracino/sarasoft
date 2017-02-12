<?php
/**
 * @author Ricardo Saracino
 * @since 10/11/16
 */

namespace AppBundle\Twig;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserDateExtension
 * @package AppBundle\Twig
 */
class UserDateExtension extends \Twig_Extension
{
	private $tokenStorage;

	const FORMAT_DATE = 'F j, Y';

	const FORMAT_DATETIME = 'F j, Y g:i A';

	/**
	 * @param TokenStorage $tokenStorage
	 */
	public function __construct(TokenStorage $tokenStorage)
	{
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->tokenStorage->getToken()->getUser();
	}

	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('user_date', array($this, 'formatUserDate')),
			new \Twig_SimpleFilter('user_datetime', array($this, 'formatUserDateTime')),
		];
	}

	/**
	 * @param \DateTime $date
	 * @param string $format
	 * @return string
	 */
	public function formatUserDate(\DateTime $date, $format = self::FORMAT_DATE)
	{
		return $date->format($format);
	}

	/**
	 * @param \DateTime $date
	 * @param string $format
	 * @return string
	 */
	public function formatUserDateTime(\DateTime $date, $format = self::FORMAT_DATETIME)
	{
		return $date->setTimezone(new \DateTimeZone($this->getUser()->getTimeZone()))->format($format);
	}
}