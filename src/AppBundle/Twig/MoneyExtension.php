<?php

namespace AppBundle\Twig;

/**
 * Class LanguageExtension
 * @package AppBundle\Twig
 */
class MoneyExtension extends \Twig_Extension
{
	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('money_float_format', array($this, 'languageFilter')),
		];
	}

	/**
	 * @param $language
	 * @param null $region
	 * @param string $displayLocale
	 * @return null|string
	 */
	public function languageFilter($language, $region = null, $displayLocale = 'en')
	{
		return \Symfony\Component\Intl\Intl::getLanguageBundle()->getLanguageName($language, $region, $displayLocale);
	}
}