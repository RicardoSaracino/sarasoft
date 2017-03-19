<?php
/**
 * @author Ricardo Saracino
 * @since 3/18/17
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserDateTimeType
 * @package AppBundle\Form\Type
 */
class UserDateTimeType extends DateType
{
	/**
	 * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
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
		$builder->addModelTransformer(new \AppBundle\Form\Transformer\UserDateTimeTransformer($this->tokenStorage));
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			[
				'widget' => 'single_text',
				'format' => \DateTime::W3C,
				'html5' => true,
				'compound' => false,
				'input' => 'sting',
				'model_timezone' => 'UTC',
				'view_timezone' => $this->tokenStorage->getToken()->getUser()->getTimeZone(),
			]
		);
	}

	/**
	 * @return null|string
	 */
	public function getBlockPrefix()
	{
		return 'date_time';
	}
}