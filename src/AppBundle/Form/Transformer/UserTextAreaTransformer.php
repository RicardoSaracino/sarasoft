<?php
/**
 * @author Ricardo Saracino
 * @since 10/30/16
 */

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserTextAreaPrependTransformer
 * @package AppBundle\Form\Transformer
 */
class UserTextAreaTransformer implements DataTransformerInterface
{
	/**
	 * @var TokenStorage
	 */
	protected $tokenStorage;

	/**
	 * @param TokenStorage $tokenStorage
	 */
	public function __construct(TokenStorage $tokenStorage)
	{
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	public function transform($value)
	{
		return $value;
	}

	/**
	 * @param mixed $value
	 * @return mixed|string
	 */
	public function reverseTransform($value)
	{
		$value = trim($value);

		if ($value) {
			$userFullName = $this->tokenStorage->getToken()->getUser()->getFullName();

			$userTimeZone = $this->tokenStorage->getToken()->getUser()->getTimeZone();

			$dateTimeZone = new \DateTimeZone($userTimeZone);

			$dateTime = new \DateTime('now', $dateTimeZone);

			return sprintf("** %s ** %s\n", $dateTime->format('Y-m-d H:i:s'), $userFullName) . $value;
		}

		return '';
	}
}