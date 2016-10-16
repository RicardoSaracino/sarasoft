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
class LanguageExtension extends \Twig_Extension
{
	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('language', array($this, 'languageFilter')),
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