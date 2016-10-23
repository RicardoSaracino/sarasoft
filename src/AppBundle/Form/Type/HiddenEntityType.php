<?php
/**
 * @author Ricardo Saracino
 * @since 10/20/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Form\Transformer\EntityToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class HiddenEntityType
 * @package AppBundle\Form
 */
class HiddenEntityType extends HiddenType
{
	/**
	 * @var ObjectManager
	 */
	private $objectManager;

	/**
	 * @param ObjectManager $objectManager
	 */
	public function __construct(ObjectManager $objectManager)
	{
		$this->objectManager = $objectManager;
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addModelTransformer(new EntityToIdTransformer($this->objectManager, $options['class']));
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver
			->setRequired(['class'])
			->setDefaults([
				'invalid_message' => 'The entity does not exist.',
				'data_class' => null,
				'compound' => false
			]);
	}
}