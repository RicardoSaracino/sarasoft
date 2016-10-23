<?php
/**
 * @author Ricardo Saracino
 * @since 10/20/16
 */

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class EntityToIdTransformer
 * @package AppBundle\Form\Transformer
 */
class EntityToIdTransformer implements DataTransformerInterface
{

	/**
	 * @var ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var string
	 */
	protected $class;

	/**
	 * @param ObjectManager $objectManager
	 * @param $class
	 */
	public function __construct(ObjectManager $objectManager, $class)
	{
		$this->objectManager = $objectManager;
		$this->class = $class;
	}


	/**
	 * @param mixed $entity
	 * @return mixed|null
	 * @throws \Symfony\Component\Form\Exception\TransformationFailedException
	 */
	public function transform($entity)
	{
		if (!$entity instanceof $this->class) {
			throw new TransformationFailedException(sprintf('Entity is not an instance of %s', $this->class));
		}

		if (!method_exists($entity, 'getId')) {
			throw new TransformationFailedException(sprintf(
				'There is no method getId for class "%s".',
				get_class($entity)
			));
		}

		return $entity->getId();
	}

	/**
	 * @param mixed $id
	 * @return mixed|null|object
	 * @throws \Symfony\Component\Form\Exception\TransformationFailedException
	 */
	public function reverseTransform($id)
	{
		if (!$id) {
			return null;
		}

		$entity = $this->objectManager
			->getRepository($this->class)
			->find($id);

		if (null === $entity) {
			throw new TransformationFailedException();
		}

		return $entity;
	}
}