<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WelcomeController extends Controller
{
    /**
     * @Route("/welcomehome")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Welcome:index.html.twig', array(
            // ...
        ));
    }

}
