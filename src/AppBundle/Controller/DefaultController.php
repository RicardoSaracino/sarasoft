<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
	/**
	 * @Route("/", name="home")
	 */
	public function homeAction()
	{
		return $this->render('default/home.html.twig', []);
	}
}
