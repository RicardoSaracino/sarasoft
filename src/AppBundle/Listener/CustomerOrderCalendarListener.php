<?php
/**
 * @author Ricardo Saracino
 * @since 10/18/16
 */

namespace AppBundle\Listener;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
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
			WHERE o.bookedFrom BETWEEN :startDate AND :endDate and o.orderStatusCode = :orderStatusCode'
		)
		->setParameter('startDate', $calendarEvent->getStart())
		->setParameter('endDate', $calendarEvent->getEnd())
		->setParameter('orderStatusCode', 'BKD');

		$customerOrders = $query->getResult();

		foreach( $customerOrders as $customerOrder )
		{
			$title = 'Booked'."\n".$customerOrder->getCustomer()->getFirstName().' '.$customerOrder->getCustomer()->getLastName();

			$calEvent = new CalEvent($title, $customerOrder->getBookedFrom());

			$calEvent->setAllDay(true);

			$calEvent->setUrl($this->router->generate('showCustomerOrder', array('id' => $customerOrder->getId())));

			$calEvent->setStartDate($customerOrder->getBookedFrom());

			$calEvent->setEndDate($customerOrder->getBookedUntil());

			$calendarEvent->addEvent($calEvent);
		}

		##############

		$query = $this->manager->createQuery(
			'SELECT o
			FROM AppBundle:CustomerOrder o
			WHERE o.startedOn BETWEEN :startDate AND :endDate and o.orderStatusCode = :orderStatusCode'
		)
		->setParameter('startDate', $calendarEvent->getStart())
		->setParameter('endDate', $calendarEvent->getEnd())
		->setParameter('orderStatusCode', 'PRG');

		$customerOrders = $query->getResult();

		foreach( $customerOrders as $customerOrder )
		{
			$title = 'In Progress'."\n".$customerOrder->getCustomer()->getFirstName().' '.$customerOrder->getCustomer()->getLastName();

			$calEvent = new CalEvent($title, $customerOrder->getStartedOn());

			$calEvent->setAllDay(true);

			$calendarEvent->addEvent($calEvent);
		}

		#$startDate = $calendarEvent->getFilters();
	}
}