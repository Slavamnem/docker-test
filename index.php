<?php

use App\Dz5\Currency;
use App\Dz5\Money;

require_once "vendor/autoload.php";

$ua = new Currency('UAH');
$usd = new Currency('USD');

$uaMoney = new Money(500, $ua);
$uaMoney2 = new Money(300, $ua);
$uaMoney3 = new Money(500, $ua);
$usdMoney = new Money(100, $usd);


if ($uaMoney->equals($uaMoney2)) {
    echo "YES<br>";
} else {
    echo "NO<br>";
}

if ($uaMoney->equals($uaMoney3)) {
    echo "YES<br>";
} else {
    echo "NO<br>";
}

if ($uaMoney->equals($usdMoney)) {
    echo "YES<br>";
} else {
    echo "NO<br>";
}


echo $uaMoney->getAmount();
$uaMoney->add($uaMoney2);
echo "<br>" . $uaMoney->getAmount();

$usdMoney->add($uaMoney);