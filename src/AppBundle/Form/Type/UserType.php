<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package AppBundle\Form
 */
abstract class UserType extends AbstractType
{
	/**
	 * @return \AppBundle\Entity\Role[]
	 */
	abstract protected function getRoleChoices();

	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addUsername(FormBuilderInterface $builder)
	{
		$builder->add('username', Type\TextType::class, ['label' => 'user.label.username']);

		return $this;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addFirstName(FormBuilderInterface $builder)
	{
		$builder->add('firstName', Type\TextType::class, ['label' => 'user.label.firstName']);

		return $this;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addLastName(FormBuilderInterface $builder)
	{
		$builder->add('lastName', Type\TextType::class, ['label' => 'user.label.lastName']);

		return $this;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addEmail(FormBuilderInterface $builder)
	{
		$builder->add('email', Type\EmailType::class, ['label' => 'user.label.email']);

		return $this;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addLanguage(FormBuilderInterface $builder)
	{
		$builder->add('language', Type\LanguageType::class, ['label' => 'user.label.language', 'preferred_choices' => ['en','fr'],'data'=>'en']);

		return $this;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addTimeZone(FormBuilderInterface $builder)
	{
		$builder->add('timeZone', Type\TimezoneType::class, [
			'label' => 'user.label.timeZone',
			'preferred_choices' => ['America/Edmonton','America/Halifax','America/Thunder_Bay','America/Toronto','America/Vancouver'],
			'data'=>'America/Toronto'
		]);

		return $this;
	}


	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addRoles(FormBuilderInterface $builder)
	{
		$builder->add(
			'roles', Type\ChoiceType::class, [
			'choices' => $this->getRoleChoices(),
			'choice_label' => 'name',
			'placeholder' => 'label.choose',
			'expanded' => true,
			'multiple' => true,
			'label' => 'user.label.roles'
		]);

		return $this;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @return $this
	 */
	protected function addPassword(FormBuilderInterface $builder)
	{
		$builder->add('plainPassword', Type\RepeatedType::class, [
			'type' => Type\PasswordType::class,
			'invalid_message' => 'The password fields must match.',
			'required' => true,
			'first_options'  => ['label' => 'user.label.password'],
			'second_options' => ['label' => 'user.label.repeatPassword'],
		]);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => \AppBundle\Entity\User::class
        ]);
    }
}