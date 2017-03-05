<?php

namespace AppBundle\Twig;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Money\Currency;
use Money\Money;

/**
 * Class UserMoneyExtension
 * @package AppBundle\Twig
 */
class UserMoneyExtension extends \Twig_Extension
{
	private $tokenStorage;

	/**
	 * @var \Tbbc\MoneyBundle\Formatter
	 */
	private $moneyFormatter;

	/**
	 * @param TokenStorage $tokenStorage
	 */
	public function __construct(TokenStorage $tokenStorage)
	{
		$this->tokenStorage = $tokenStorage;

		$this->moneyFormatter = new \Tbbc\MoneyBundle\Formatter\MoneyFormatter;
	}


	/**
	 * @return array
	 */
	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('user_money', array($this, 'formatUserMoney')),
		];
	}

	/**
	 * @param Money $money
	 * @return string
	 */
	public function formatUserMoney(Money $money)
	{
		return '$'.$this->moneyFormatter->formatAmount($money, '.') . ' ' . $money->getCurrency();
	}
}