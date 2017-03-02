<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Util;

/**
 * Class AddressHelper
 * @package AppBundle\Util
 */
class AddressHelper
{
	/**
	 * @param string $locale
	 * @return array
	 */
	public static function getSubdivisionOptions($locale = 'en')
	{
		$subdivisionRepository = new \CommerceGuys\Addressing\Repository\SubdivisionRepository();

		return array('Provinces' => array_flip($subdivisionRepository->getList('CA',null,$locale)), 'States' => array_flip($subdivisionRepository->getList('US',null,$locale)));
	}
}