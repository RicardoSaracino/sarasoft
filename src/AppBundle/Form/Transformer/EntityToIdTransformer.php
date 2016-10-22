<?php
/**
 * @author Ricardo Saracino
 * @since 10/20/16
 */

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
#use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\Exception\TransformationFailedException;;

/**
 * Class EntityToIdTransformer
 * @package AppBundle\Form\Transformer
 */
class EntityToIdTransformer implements DataTransformerInterface
{
	/**
	 * @param mixed $entity
	 * @return mixed|null
	 * @throws \Symfony\Component\Form\Exception\TransformationFailedException
	 */
	public function transform($entity)
	{
		if (!is_object ($entity)) {
			throw new TransformationFailedException(sprintf('EntityToIdTransformer::transform requires an object'));
		}

		if (!method_exists($entity, 'getId')) {
			throw new TransformationFailedException(sprintf('There is no method getId for class "%s".', get_class($entity)));
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
		/*if (!$id) {
			return null;
		}

		$entity = $this->objectManager
			->getRepository($this->class)
			->find($id);

		if (null === $entity) {
			throw new TransformationFailedException();
		}

		return $entity; */
	}
}