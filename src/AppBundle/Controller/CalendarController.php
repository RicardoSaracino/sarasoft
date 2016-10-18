<?php
/**
 * @author Ricardo Saracino
 * @since 10/17/16
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class CalendarController
 * @package AppBundle\Controller
 *
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
	/**
	 * @Route("/", name="calendar_index")
	 */
	public function indexAction()
	{
		return $this->render('calendar/index.html.twig', []);
	}
}
