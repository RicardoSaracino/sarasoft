<?php
/**
 * @author Ricardo Saracino
 * @since 10/5/16
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class WelcomeController
 * @package AppBundle\Controller
 *
 * @Route("/welcome")
 */
class WelcomeController extends Controller
{
	/**
	 * @Route("/", name="welcome")
	 */
	public function indexAction()
	{
		return $this->render('welcome/index.html.twig', []);
	}
}
