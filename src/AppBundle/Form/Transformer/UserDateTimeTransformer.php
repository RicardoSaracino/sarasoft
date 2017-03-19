<?php
/**
 * @author Ricardo Saracino
 * @since 3/19/17
 */

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class UserDateTimeTransformer
 * @package AppBundle\Form\Transformer
 */
class UserDateTimeTransformer implements DataTransformerInterface
{
	/**
	 * @var TokenStorage
	 */
	protected $tokenStorage;

	protected $html5Format;

	/**
	 * @param TokenStorage $tokenStorage
	 * @param string $html5Format
	 */
	public function __construct(TokenStorage $tokenStorage, $html5Format = 'Y-m-d\Th:i')
	{
		$this->tokenStorage = $tokenStorage;

		$this->html5Format = $html5Format;
	}

	/**
	 * @param \DateTime $dateTime
	 * @return string
	 */
	public function transform($dateTime)
	{
		$userTimeZone = $this->tokenStorage->getToken()->getUser()->getTimeZone();

		return $dateTime->setTimezone(new \DateTimeZone($userTimeZone))->format($this->html5Format);
	}

	/**
	 * @param mixed $value
	 * @return \DateTime
	 */
	public function reverseTransform($value)
	{
		$userTimeZone = $this->tokenStorage->getToken()->getUser()->getTimeZone();

		$dateTime = new \DateTime($value, new \DateTimeZone($userTimeZone));

		return $dateTime->setTimezone(new \DateTimeZone($userTimeZone));
	}
}