<?php
/**
 * @author Ricardo Saracino
 * @since 10/5/16
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\FormError;

/**
 * Class SecurityController
 * @package AppBundle\Controller
 */
class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(Request $request)
	{
		$loginForm = $this->createForm(\AppBundle\Form\LoginType::class, null, ['method' => 'POST']);

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