<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\Model\ChangePassword;


/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
	/**
	 * Lists all User entities.
	 *
	 * @Route("/", name="user_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$users = $em->getRepository(User::class)->findAll();

		return $this->render(
			'user/index.html.twig',
			[
				'users' => $users,
			]
		);
	}

	/**
	 * Creates a new User entity.
	 *
	 * @Route("/new", name="user_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$user = new User();

		$form = $this->createForm(UserType::class, $user, ['validation_groups' => ['Default','plain_password']]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$encoder = $this->container->get('security.password_encoder');
			$user->setSalt(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
			$encodedPassword = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
			$user->setPassword($encodedPassword);

			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
		}

		return $this->render(
			'user/new.html.twig',
			[
				'user' => $user,
				'form' => $form->createView(),
			]
		);
	}

	/**
	 * Finds and displays a User entity.
	 *
	 * @Route("/{id}", name="user_show")
	 * @Method("GET")
	 */
	public function showAction(User $user)
	{
		return $this->render(
			'user/show.html.twig',
			[
				'user' => $user
			]
		);
	}

	/**
	 * Displays a form to edit an existing User entity.
	 *
	 * @Route("/{id}/edit", name="user_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, User $user)
	{
		$editForm = $this->createForm(UserType::class, $user);

		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_show', array('id' => $user->getId()));
		}

		return $this->render(
			'user/edit.html.twig',
			[
				'user' => $user,
				'edit_form' => $editForm->createView(),
			]
		);
	}


	/**
	 * Displays a form to edit an existing User entity password.
	 *
	 * @Route("/{id}/password", name="user_change_password")
	 * @Method({"GET", "POST"})
	 */
	public function changePasswordAction(Request $request, User $user)
	{
		$changePasswordModel = new ChangePassword();
		$changePasswordForm = $this->createForm(ChangePasswordType::class, $changePasswordModel);
		$changePasswordForm->handleRequest($request);

		if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$encoder = $this->container->get('security.password_encoder');
			$user->setSalt(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
			$encodedPassword = $encoder->encodePassword($changePasswordModel->getNewPassword(), $user->getSalt());
			$user->setPassword($encodedPassword);

			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
		}

		return $this->render(
			'user/change_password.html.twig',
			[
				'user' => $user,
				'change_password_form' => $changePasswordForm->createView(),
			]
		);
	}

	/**
	 * Deletes a User entity.
	 *
	 * @Route("/{id}", name="user_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, User $user)
	{
		$form = $this->createDeleteForm($user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($user);
			$em->flush();
		}

		return $this->redirectToRoute('user_index');
	}

	/**
	 * Creates a form to delete a User entity.
	 *
	 * @param User $user The User entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(User $user)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('user_delete', ['id' => $user->getId()]))
			->setMethod('DELETE')
			->getForm();
	}
}
