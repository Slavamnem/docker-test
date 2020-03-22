<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 22.03.20
 * Time: 16:58
 */
namespace App\Dz5;

use Payum\ISO4217\ISO4217 AS Iso4217;
use Payum\ISO4217\Currency AS CurrencyLib;

class Currency
{
    /**
     * @var string
     */
    private $isoCode;

    /**
     * Currency constructor.
     * @param string $isoCode
     */
    public function __construct(string $isoCode)
    {
        $this->setIsoCode($isoCode);
    }

    /**
     * @return string
     */
    public function getIsoCode():string
    {
        return $this->isoCode;
    }

    /**
     * @param string $isoCode
     * @return Currency
     */
    public function setIsoCode($isoCode): Currency
    {
        if (!in_array($isoCode, $this->getAvailableCurrencies())) {
            throw new \InvalidArgumentException('Code does not exist');
        }

        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * @param Currency $currency
     * @return bool
     */
    public function equals(Currency $currency): bool
    {
        return $this->getIsoCode() == $currency->getIsoCode();
    }

    /**
     * @return array
     */
    private function getAvailableCurrencies(): array
    {
        return array_map(
            function (CurrencyLib $currency){ return $currency->getAlpha3(); },
            (new Iso4217())->findAll()
        );
    }
}
