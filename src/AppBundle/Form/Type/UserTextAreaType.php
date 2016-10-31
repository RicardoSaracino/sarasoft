<?php
/**
 * @author Ricardo Saracino
 * @since 10/30/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Form\Transformer\UserTextAreaTransformer;


/**
 * Class UserTextAreaType
 * @package AppBundle\Form\Type
 */
class UserTextAreaType extends TextareaType
{
	/**
	 * @var TokenStorage
	 */
	private $tokenStorage;

	/**
	 * @param TokenStorage $tokenStorage
	 */
	public function __construct(TokenStorage $tokenStorage)
	{
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder->addModelTransformer(new UserTextAreaTransformer($this->tokenStorage));

		parent::buildForm($builder, $options);

	}
}