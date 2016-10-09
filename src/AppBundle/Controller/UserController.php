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

		$users = $em->getRepository('AppBundle:User')->findAll();

		return $this->render(
			'user/index.html.twig',
			array(
				'users' => $users,
			)
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
		$form = $this->createForm('AppBundle\Form\UserType', $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$user->setUpdatedAt($user->setCreatedAt(new \DateTime(\DateTimeZone::UTC))->getCreatedAt());
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_show', array('id' => $user->getId()));
		}

		return $this->render(
			'user/new.html.twig',
			array(
				'user' => $user,
				'form' => $form->createView(),
			)
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
		$deleteForm = $this->createDeleteForm($user);

		return $this->render(
			'user/show.html.twig',
			array(
				'user' => $user,
				'delete_form' => $deleteForm->createView(),
			)
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
		#$deleteForm = $this->createDeleteForm($user);
		$editForm = $this->createForm('AppBundle\Form\UserType', $user);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$user->setUpdatedAt(new \DateTime(\DateTimeZone::UTC));
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
		}

		return $this->render(
			'user/edit.html.twig',
			array(
				'user' => $user,
				'edit_form' => $editForm->createView(),
				#'delete_form' => $deleteForm->createView(),
			)
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

		$changePasswordForm = $this->createForm('AppBundle\Form\ChangePasswordType', $changePasswordModel);
		$changePasswordForm->handleRequest($request);

		if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$encoder = $this->container->get('security.password_encoder');
			$encodedPassword = $encoder->encodePassword($user, $changePasswordModel->getNewPassword());
			$user->setPassword($encodedPassword);
			$user->setUpdatedAt(new \DateTime(\DateTimeZone::UTC));
			$user->setUpdatedPasswordAt(new \DateTime(\DateTimeZone::UTC));
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
		}

		return $this->render(
			'user/change_password.html.twig',
			array(
				'user' => $user,
				'change_password_form' => $changePasswordForm->createView(),
			)
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
			->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
			->setMethod('DELETE')
			->getForm();
	}
}
