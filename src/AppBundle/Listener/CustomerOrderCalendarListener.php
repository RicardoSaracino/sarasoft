<?php
/**
 * @author Ricardo Saracino
 * @since 10/18/16
 */

namespace AppBundle\Listener;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AppBundle\Entity\CustomerOrder;
use AppBundle\Event\CustomerOrderCalendarEvent as CalEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class CalendarListener
 * @package AppBundle\Listener
 */
class CustomerOrderCalendarListener
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $manager;

	/**
	 * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
	 */
	private $router;

	/**
	 * @param EntityManager $manager
	 * @param Router $router
	 */
	public function __construct(EntityManager $manager, Router $router)
	{
		$this->manager = $manager;

		$this->router = $router;
	}

	/**
	 * @param CalendarEvent $calendarEvent
	 */
	public function loadData(CalendarEvent $calendarEvent)
	{
		$query = $this->manager->createQuery(
			'SELECT o
			FROM AppBundle:CustomerOrder o
			WHERE o.bookedFrom BETWEEN :startDate AND :endDate'
		)
			->setParameter('startDate', $calendarEvent->getStart())
			->setParameter('endDate', $calendarEvent->getEnd());

		$customerOrders = $query->getResult();

		/* @var $customerOrder \AppBundle\Entity\CustomerOrder */
		foreach ($customerOrders as $customerOrder) {

			switch( $customerOrder->getStatus() )
			{
				case CustomerOrder::STATUS_BOOKED:

					$title = 'Booked' . "\n" . $customerOrder->getCustomer()->getFirstName() . ' ' . $customerOrder->getCustomer()->getLastName();

					$calEvent = new CalEvent($title, $customerOrder->getBookedFrom());

					$calEvent->setUrl($this->router->generate('showCustomerOrder', array('id' => $customerOrder->getId())));

					$calEvent->setStartDate($customerOrder->getBookedFrom());

					$calEvent->setEndDate($customerOrder->getBookedUntil());

					$calendarEvent->addEvent($calEvent);

					break;


				case CustomerOrder::STATUS_INPROGRESS:

					$title = 'In Progress' . "\n" . $customerOrder->getCustomer()->getFirstName() . ' ' . $customerOrder->getCustomer()->getLastName();

					$calEvent = new CalEvent($title, $customerOrder->getBookedFrom());

					$calEvent->setUrl($this->router->generate('showCustomerOrder', array('id' => $customerOrder->getId())));

					$calEvent->setStartDate($customerOrder->getBookedFrom());

					$calEvent->setEndDate($customerOrder->getBookedUntil());

					$calendarEvent->addEvent($calEvent);

					break;


				case CustomerOrder::STATUS_COMPLETE:

					$title = 'Complete' . "\n" . $customerOrder->getCustomer()->getFirstName() . ' ' . $customerOrder->getCustomer()->getLastName();

					$calEvent = new CalEvent($title, $customerOrder->getBookedFrom());

					$calEvent->setUrl($this->router->generate('showCustomerOrder', array('id' => $customerOrder->getId())));

					$calEvent->setStartDate($customerOrder->getBookedFrom());

					$calEvent->setEndDate($customerOrder->getBookedUntil());

					$calendarEvent->addEvent($calEvent);

					break;
			}


		}


		#$startDate = $calendarEvent->getFilters();
	}
}