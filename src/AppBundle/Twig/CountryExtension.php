<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Twig;

/**
 * Class CountryExtension
 * @package AppBundle\Twig
 */
class CountryExtension extends \Twig_Extension
{
	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('country', array($this, 'countryFilter')),
		];
	}

	/**
	 * @param $countryCode
	 * @param string $locale
	 * @return null|string
	 */
	public function countryFilter($countryCode, $locale = 'en')
	{
		return \Symfony\Component\Intl\Intl::getRegionBundle()->getCountryName($countryCode, $locale);
	}
}