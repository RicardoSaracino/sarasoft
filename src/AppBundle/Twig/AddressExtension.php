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
class AddressExtension extends \Twig_Extension
{
	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('administrative_area', array($this, 'administrativeAreaFilter')),
			new \Twig_SimpleFilter('country', array($this, 'countryFilter')),
		];
	}

	/**
	 * @param $administrativeArea
	 * @param string $locale
	 * @return string
	 */
	public function administrativeAreaFilter($administrativeArea, $locale = 'en')
	{
		$subdivisionRepository = new \CommerceGuys\Addressing\Repository\SubdivisionRepository();

		if($subdivision = $subdivisionRepository->get($administrativeArea,$locale)){

			dump($subdivision);

			return $subdivision->getName();
		}

		return '';
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