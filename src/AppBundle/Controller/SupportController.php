<?php
/**
 * @author Ricardo Saracino
 * @since 3/11/17
 */

namespace AppBundle\Controller;

use AppBundle\Doctrine\DBAL\Type\UTCDateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SupportController
 * @package AppBundle\Controller
 */
class SupportController extends Controller
{
	/**
	 * @param \AppBundle\Form\Model\Support $support
	 * @return mixed
	 */
	protected function email(\AppBundle\Form\Model\Support $support)
	{
		$message = \Swift_Message::newInstance()
			->setSubject(sprintf('%s - Support Email - %s', $this->container->getParameter('site_name'), $support->getSubject()))
			->setFrom($support->getUser()->getEmail())
			->setTo($this->container->getParameter('support_email'))
			->setBody(
				$this->renderView(
					'support/email.html.twig',
					[
						'support' => $support
					]
				),
				'text/html'
			);

		return $this->get('mailer')->send($message);
	}

	/**
	 * @Route("/support", name="support")
	 * @Method({"GET", "POST"})
	 */
	public function sendSupportAction(Request $request)
	{
		$support = new \AppBundle\Form\Model\Support();

		$support
			->setDate(new \DateTime(null, new \DateTimeZone('UTC')))
			->setUser($this->get('security.token_storage')->getToken()->getUser())
			->setVersion($this->container->getParameter('site_version'));

		$form = $this->createForm('AppBundle\Form\Type\SupportType', $support);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			## always true
			if ($r = $this->email($support)) {
				$this->addFlash('info', 'Support email sent.');
			}

			/* return $this->render(
				'support/email.html.twig',
				[
					'support' => $support
				]
			);*/
		}

		return $this->render(
			'support/support.html.twig',
			[
				'support' => $support,
				'form' => $form->createView()
			]
		);
	}
}