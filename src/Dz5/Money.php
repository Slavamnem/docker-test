<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 22.03.20
 * Time: 22:40
 */

namespace App\Dz5;

class Money
{
    /**
     * @var int|float
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * Money constructor.
     * @param $amount
     * @param Currency $currency
     */
    public function __construct($amount, Currency $currency)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    /**
     * @return float|int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|int $amount
     * @return Money
     */
    public function setAmount($amount): Money
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return Money
     */
    public function setCurrency(Currency $currency): Money
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @param Money $money
     * @return bool
     */
    public function equals(Money $money): bool
    {
        return (
            $money->getAmount() == $this->getAmount() &&
            $money->getCurrency()->getIsoCode() == $this->getCurrency()->getIsoCode()
        );
    }

    /**
     * @param Money $money
     */
    public function add(Money $money): void
    {
        if ($this->getCurrency()->getIsoCode() != $money->getCurrency()->getIsoCode()) {
            throw new \InvalidArgumentException('Currencies are not the same');
        }

        $this->amount += $money->getAmount();
    }
}
