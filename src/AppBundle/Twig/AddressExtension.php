<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Twig;

use AppBundle\Entity\Address;

/**
 * Class AddressExtension
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
	 * @param Address $address
	 * @param string $locale
	 * @return string
	 */
	public function administrativeAreaFilter(Address $address, $locale = 'en')
	{
		$subdivisionRepository = new \CommerceGuys\Addressing\Repository\SubdivisionRepository();

		if($subdivision = $subdivisionRepository->get($address->getAdministrativeArea(),$locale)){

			return $subdivision->getName();
		}

		return '';
	}

	/**
	 * @param Address $address
	 * @param string $locale
	 * @return null|string
	 */
	public function countryFilter(Address $address, $locale = 'en')
	{
		return \Symfony\Component\Intl\Intl::getRegionBundle()->getCountryName($address->getCountryCode(), $locale);
	}
}