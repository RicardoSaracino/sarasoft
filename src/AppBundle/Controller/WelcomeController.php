<?php
/**
 * @author Ricardo Saracino
 * @since 10/5/16
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WelcomeController extends Controller
{
	/**
	 * @Route("/welcome")
	 */
	public function indexAction()
	{
		return $this->render(
			'AppBundle:Welcome:index.html.twig',
			array(// ...
			)
		);
	}

}
