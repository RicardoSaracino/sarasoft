<?php
/**
 * @author Ricardo Saracino
 * @since 10/18/16
 */

namespace AppBundle\Listener;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AppBundle\Entity\CustomerOrder;
use AppBundle\Event\CustomerOrderCalendarEvent;
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
		#				OR (:endDate BETWEEN o.bookedFrom AND o.bookedUntil AND status = "'.CustomerOrder::STATUS_BOOKED.'")


		$query = $this->manager->createQuery(
			'SELECT o

			FROM AppBundle:CustomerOrder o

			WHERE :startDate BETWEEN o.bookedFrom AND o.bookedUntil

				OR :endDate BETWEEN o.bookedFrom AND o.bookedUntil

				OR o.completedAt BETWEEN :startDate AND :endDate

				OR o.invoicedAt BETWEEN :startDate AND :endDate

				OR o.cancelledAt BETWEEN :startDate AND :endDate
				'
		)
			->setParameter('startDate', $calendarEvent->getStart())
			->setParameter('endDate', $calendarEvent->getEnd());

		$customerOrders = $query->getResult();

		/* @var $customerOrder \AppBundle\Entity\CustomerOrder */
		foreach ($customerOrders as $customerOrder) {

			$calEvent = null;

			switch ($customerOrder->getStatus()) {
				case CustomerOrder::STATUS_BOOKED:

					$calEvent = new CustomerOrderCalendarEvent('Booked', $customerOrder->getBookedFrom());

					$calEvent->setUrl($this->router->generate('customer_order_edit_booked', array('id' => $customerOrder->getId())));

					$calEvent->setStartDate($customerOrder->getBookedFrom());

					$calEvent->setEndDate($customerOrder->getBookedUntil());

					$calEvent->setNotes($customerOrder->getBookingNotes());

					break;


				case CustomerOrder::STATUS_INPROGRESS:

					$calEvent = new CustomerOrderCalendarEvent('In Progress', $customerOrder->getProgressStartedAt());

					$calEvent->setUrl($this->router->generate('customer_order_edit_inprogress', array('id' => $customerOrder->getId())));

					$calEvent->setStartDate($customerOrder->getProgressStartedAt());

					$calEvent->setEndDate($customerOrder->getBookedUntil());

					$calEvent->setNotes($customerOrder->getProgressNotes());

					break;


				case CustomerOrder::STATUS_COMPLETE:

					$calEvent = new CustomerOrderCalendarEvent('Complete', $customerOrder->getCompletedAt());

					$calEvent->setUrl($this->router->generate('customer_order_edit_complete', array('id' => $customerOrder->getId())));

					$calEvent->setNotes($customerOrder->getCompletionNotes());

					break;

				case CustomerOrder::STATUS_INVOICED:

					$calEvent = new CustomerOrderCalendarEvent('Invoiced', $customerOrder->getInvoicedAt());

					$calEvent->setUrl($this->router->generate('customer_order_edit_invoice', array('id' => $customerOrder->getId())));

					$calEvent->setNotes($customerOrder->getInvoiceNotes());

					break;

				case CustomerOrder::STATUS_PAID:

					$calEvent = new CustomerOrderCalendarEvent('Paid', $customerOrder->getInvoicedAt());

					$calEvent->setUrl($this->router->generate('customer_order_edit_invoice', array('id' => $customerOrder->getId())));

					$calEvent->setNotes($customerOrder->getPaymentNotes());

					break;

				case CustomerOrder::STATUS_CANCELLED:

					$calEvent = new CustomerOrderCalendarEvent('Cancelled', $customerOrder->getCancelledAt());

					$calEvent->setUrl($this->router->generate('customer_order_edit_cancelled', array('id' => $customerOrder->getId())));

					$calEvent->setNotes($customerOrder->getCancellationNotes());

					break;
			}

			if (!is_null($calEvent)) {

				$calEvent->setCustomerName($customerOrder->getCustomer()->getFullName());

				$calEvent->setOrderTypeName($customerOrder->getOrderType()->getName());

				$calendarEvent->addEvent($calEvent);
			}
		}
	}
}