<?php
/**
 * @author Ricardo Saracino
 * @since 10/5/16
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SecurityController
 * @package AppBundle\Controller
 */
class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="login")
	 * @Method({"GET", "POST"})
	 */
	public function loginAction(Request $request)
	{
		$loginForm = $this->createForm('\AppBundle\Form\Type\LoginType');

		$loginForm->handleRequest($request);

		$authenticationUtils = $this->get('security.authentication_utils');

		# get the login error if there is one
		if($authenticationException = $authenticationUtils->getLastAuthenticationError()){

			$loginForm->addError(new FormError($authenticationException->getMessageKey()));
		}

		return $this->render(
			'security/login.html.twig',[
				'login_form' => $loginForm->createView(),
				'last_username' => $authenticationUtils->getLastUsername(),
			]
		);
	}

	/**
	 * @Route("/logout", name="logout")
	 */
	public function logoutAction(Request $request)
	{
	}
}