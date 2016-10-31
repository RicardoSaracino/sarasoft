<?php
/**
 * @author Ricardo Saracino
 * @since 10/30/16
 */

namespace AppBundle\Form\Type;

use AppBundle\Form\Transformer\UserTextAreaPrependTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Doctrine\ORM\EntityManager;


/**
 * Class PrependTextAreaType
 * @package AppBundle\Form\Type
 */
class UserTextAreaPrependType extends AbstractType
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;
	/**
	 * @var TokenStorage
	 */
	private $tokenStorage;

	/**
	 * @param EntityManager $entityManager
	 * @param TokenStorage $tokenStorage
	 */
	public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage)
	{
		$this->entityManager = $entityManager;
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$accessor = PropertyAccess::createPropertyAccessor();

		$orig_data = $accessor->getValue($options['data'],$builder->getName());

		$builder

			->add('orig_'.$builder->getName(), TextareaType::class, ['label' => 'Previous', 'disabled' => true, 'data' => $orig_data, 'mapped' => false])

			->add($builder->getName(), TextareaType::class, ['label' => 'New', 'trim' => true, 'data' => '']);

		$builder->addModelTransformer(new UserTextAreaPrependTransformer($this->entityManager,$this->tokenStorage,$options['data_class'],$builder->getName()));


	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver
			->setRequired(['data_class', 'data']);
	}
}