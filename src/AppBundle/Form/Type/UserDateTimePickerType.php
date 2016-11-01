<?php
/**
 * @author Ricardo Saracino
 * @since 10/28/16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DatePickerType
 * @package AppBundle\Form\Type
 */
class UserDateTimePickerType extends \Symfony\Component\Form\Extension\Core\Type\DateType
{
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
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			[
				'widget' => 'single_text',
				'format' => 'MM/dd/yyyy hh:mm a',
				'html5' => false,
				'compound' => false,
				'input' => null,
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
		return 'date_time_picker';
	}
}