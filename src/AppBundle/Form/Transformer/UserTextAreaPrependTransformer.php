<?php
/**
 * @author Ricardo Saracino
 * @since 10/30/16
 */

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Doctrine\ORM\EntityManager;

/**
 * Class UserTextAreaPrependTransformer
 * @package AppBundle\Form\Transformer
 */
class UserTextAreaPrependTransformer implements DataTransformerInterface
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * @var TokenStorage
	 */
	protected $tokenStorage;

	/**
	 * @var string
	 */
	protected $class;

	/**
	 * @var string
	 */
	protected $field;

	/**
	 * @param EntityManager $entityManager
	 * @param TokenStorage $tokenStorage
	 * @param $class
	 * @param $field
	 */
	public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage, $class, $field)
	{
		$this->entityManager = $entityManager;
		$this->tokenStorage = $tokenStorage;

		$this->class = $class;
		$this->field = $field;
	}

	/**
	 * @param mixed $values
	 * @return mixed
	 */
	public function transform($values)
	{
		return $values;
	}

	/**
	 * @param mixed $entity
	 * @return mixed|string
	 */
	public function reverseTransform($entity)
	{
		$accessor = PropertyAccess::createPropertyAccessor();

		$newValue = trim($accessor->getValue($entity, $this->field));

		$notes = '';

		if ($newValue) {
			$userFullName = $this->tokenStorage->getToken()->getUser()->getFullName();

			$userTimeZone = $this->tokenStorage->getToken()->getUser()->getTimeZone();

			$dateTimeZone = new \DateTimeZone($userTimeZone);

			$dateTime = new \DateTime('now', $dateTimeZone);

			$notes .= sprintf("** %s ** %s\n", $dateTime->format('Y-m-d H:i:s'), $userFullName) . $newValue;
		}

		$uow = $this->entityManager->getUnitOfWork();

		$origData = $uow->getOriginalEntityData($entity);

		if (array_key_exists($this->field, $origData)) {
			$origValue = trim($origData[$this->field]);

			if (strlen($origValue) > 0) {

				$notes .= "\n" . $origValue;
			}
		}

		return trim($notes);
	}
}