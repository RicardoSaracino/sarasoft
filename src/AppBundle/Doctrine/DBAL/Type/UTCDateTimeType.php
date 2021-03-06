<?php
/**
 * @author Ricardo Saracino
 * @since 10/15/16
 */

namespace AppBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;

/**
 * Class UTCDateTimeType
 * @package AppBundle\Doctrine\DBLA\Type
 */
class UTCDateTimeType extends DateTimeType
{
	/**
	 * @var null
	 */
	static private $utc = null;

	/**
	 * @param mixed $value
	 * @param AbstractPlatform $platform
	 * @return mixed|null
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value === null) {
			return null;
		}

		if (is_null(self::$utc)) {
			self::$utc = new \DateTimeZone('UTC');
		}

		$value->setTimeZone(self::$utc);

		return $value->format($platform->getDateTimeFormatString());
	}

	/**
	 * @param mixed $value
	 * @param AbstractPlatform $platform
	 * @return \DateTime|mixed|null
	 * @throws \Doctrine\DBAL\Types\ConversionException
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		if ($value === null) {
			return null;
		}

		if (is_null(self::$utc)) {
			self::$utc = new \DateTimeZone('UTC');
		}

		$val = \DateTime::createFromFormat($platform->getDateTimeFormatString(), $value, self::$utc);

		if (!$val) {
			throw ConversionException::conversionFailed($value, $this->getName());
		}

		return $val;
	}
}