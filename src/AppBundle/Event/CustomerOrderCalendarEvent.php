<?php
/**
 * @author Ricardo Saracino
 * @since 10/18/16
 */

namespace AppBundle\Event;

use AncaRebeca\FullCalendarBundle\Model\Event as BaseEvent;

/**
 * Class CustomerOrderCalendarEvent
 * @package AppBundle\Event
 */
class CustomerOrderCalendarEvent extends BaseEvent
{
	/**
	 * @param string $statusName
	 * @param \DateTime $start
	 */
	public function __construct($statusName, \DateTime $start)
	{
		$this->title = '';
		$this->setStatusName($statusName);
		$this->startDate = $start;
	}


	/**
	 * @param $statusName
	 */
	public function setStatusName($statusName)
	{
		$this->setCustomField('statusName', $statusName);
	}

	/**
	 *
	 */
	public function getStatusName()
	{
		return $this->getCustomFieldValue('statusName');
	}


	/**
	 * @param $customerName
	 */
	public function setCustomerName($customerName)
	{
		$this->setCustomField('customerName', $customerName);
	}

	/**
	 *
	 */
	public function getCustomerName()
	{
		return $this->getCustomFieldValue('customerName');
	}

	/**
	 * @param $orderTypeName
	 */
	public function setOrderTypeName($orderTypeName)
	{
		$this->setCustomField('orderTypeName', $orderTypeName);
	}

	/**
	 *
	 */
	public function getOrderTypeName()
	{
		return $this->getCustomFieldValue('orderTypeName');
	}

	/**
	 * @param $notes
	 */
	public function setNotes($notes)
	{
		$this->setCustomField('notes', $notes);
	}

	/**
	 *
	 */
	public function getNotes()
	{
		return $this->getCustomFieldValue('notes');
	}
}