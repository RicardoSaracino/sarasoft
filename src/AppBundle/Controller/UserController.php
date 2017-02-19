<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Model\ChangePassword;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
	/**
	 * Lists all User entities.
	 *
	 * @Route("/", name="user_index")
	 * @Method("GET")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function indexAction()
	{
		$users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllowedUsers($this->get('security.token_storage')->getToken()->getUser());

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
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function newAction(Request $request)
	{
		$user = new User();

		$form = $this->createForm('AppBundle\Form\Type\UserNewType', $user, ['validation_groups' => ['new']]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$encoder = $this->container->get('security.password_encoder');
			$user->setSalt(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
			$encodedPassword = $encoder->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($encodedPassword);

			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
		}

		return $this->render(
			'user/new.html.twig',
			[
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
		$this->denyAccessUnlessGranted(\AppBundle\Security\UserVoter::VIEW, $user);

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
		$this->denyAccessUnlessGranted(\AppBundle\Security\UserVoter::EDIT, $user);

		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			$form = $this->createForm('AppBundle\Form\Type\UserEditType', $user, ['validation_groups' => ['edit']]);
		} else {
			$form = $this->createForm('AppBundle\Form\Type\UserEditRoleUserType', $user);
		}

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('user_show', array('id' => $user->getId()));
		}

		return $this->render(
			'user/edit.html.twig',
			[
				'user' => $user,
				'form' => $form->createView(),
			]
		);
	}


	/**
	 * Displays a form to edit an existing User entity password.
	 *
	 * @Route("/{id}/password", name="user_change_password")
	 * @Method({"GET", "POST"})
	 *
	 */
	public function changePasswordAction(Request $request, User $user)
	{
		$this->denyAccessUnlessGranted(\AppBundle\Security\UserVoter::EDIT, $user);

		$changePasswordModel = new ChangePassword();
		$changePasswordForm = $this->createForm('AppBundle\Form\Type\ChangePasswordType', $changePasswordModel);
		$changePasswordForm->handleRequest($request);

		if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$encoder = $this->container->get('security.password_encoder');
			$user->setSalt(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
			$user->setPlainPassword($changePasswordModel->getNewPassword());
			$encodedPassword = $encoder->encodePassword($user, $user->getPlainPassword());
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
}
