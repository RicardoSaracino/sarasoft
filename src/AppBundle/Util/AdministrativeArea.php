<?php
/**
 * @author Ricardo Saracino
 * @since 10/16/16
 */

namespace AppBundle\Util;

/**
 * Class AdministrativeArea
 * @package AppBundle\Util
 */
class AdministrativeArea
{
	/**
	 * @param string $lang
	 * @return array
	 */
	public static function getOptions($lang = 'en')
	{
		return array('Provinces' => array_flip(self::getProvinces()), 'States' => array_flip(self::getStates()));
	}

	/**
	 * @param string $lang
	 * @return array
	 */
	public static function getProvinces($lang = 'en')
	{
		return array(
			'AB' => 'Alberta',
			'BC' => 'British Columbia',
			'MB' => 'Manitoba',
			'NB' => 'New Brunswick',
			'NF' => 'Newfoundland',
			'NT' => 'Northwest Territories',
			'NS' => 'Nova Scotia',
			'NU' => 'Nunavut',
			'ON' => 'Ontario',
			'PE' => 'Prince Edward Island',
			'QC' => 'Quebec',
			'SK' => 'Saskatchewan',
			'YT' => 'Yukon Territory',
		);
	}

	/**
	 * @param string $lang
	 * @return array
	 */
	public static function getStates($lang = 'en')
	{
		# http://snipplr.com/view/14806/
		return array(
			'AK' => 'Alaska',
			'AL' => 'Alabama',
			'AR' => 'Arkansas',
			'AZ' => 'Arizona',
			'CA' => 'California',
		);
	}
}