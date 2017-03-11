<?php
/**
 * @author Ricardo Saracino
 * @since 3/11/17
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
/**
 * Class SupportType
 * @package AppBundle\Form\Type
 */
class SupportType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('subject')->add('message',TextareaType::class);
	}
}