<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Twig;

/**
 * Class AdministrativeAreaExtension
 * @package AppBundle\Twig
 */
class AdministrativeAreaExtension extends \Twig_Extension
{
	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('administrative_area', array($this, 'administrativeAreaFilter')),
		];
	}

	/**
	 * @param $stateProvince
	 * @param null $region
	 * @param string $displayLocale
	 * @return mixed
	 */
	public function administrativeAreaFilter($stateProvince, $region = null, $displayLocale = 'en')
	{
		return \AppBundle\Util\AdministrativeArea::getProvinces()[$stateProvince];
	}
}