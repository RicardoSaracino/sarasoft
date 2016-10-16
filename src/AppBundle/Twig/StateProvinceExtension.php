<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Twig;

/**
 * Class LanguageExtension
 * @package AppBundle\Twig
 */
class StateProvinceExtension extends \Twig_Extension
{
	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('stateProvince', array($this, 'stateProvinceFilter')),
		];
	}

	/**
	 * @param $stateProvince
	 * @param null $region
	 * @param string $displayLocale
	 * @return mixed
	 */
	public function stateProvinceFilter($stateProvince, $region = null, $displayLocale = 'en')
	{
		return \AppBundle\Util\StateProvince::getProvinces()[$stateProvince];
	}
}