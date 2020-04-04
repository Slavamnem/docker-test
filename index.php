<?php

use App\Dz5\Currency;
use App\Dz5\Money;
use App\Dz8\User;
use App\Dz7\UserV1;
use App\Dz7\UserV2;

require_once "vendor/autoload.php";

////////////////////////////
/////////// Dz8 ////////////
////////////////////////////


echo "<br>-------------- Dz 8 ---------------<br>";

$user = User::find(1);
$user->setStatus(3);
$user->update();

var_dump($user);

$user = (new User())
    ->setName('Igor')
    ->setStatus(1)
    ->setEmail('igor@gmail.com');

print_r($user->create());

User::delete(2);


////////////////////////////
/////////// Dz7 ////////////
////////////////////////////


echo "<br>-------------- Dz 7 --------------- <br>";

var_dump(UserV1::findById(2));
var_dump(UserV1::findByEmailAndByStatus('slava@gmail.com', 1));
var_dump(UserV1::findBetweenCreatedAt('2020-01-01 00:00:00', '2020-02-01 00:00:00'));
var_dump(UserV1::findBetweenCreatedAtAndByStatus('2020-01-01 00:00:00', '2020-02-01 00:00:00', 1));
var_dump(UserV1::findBetweenCreatedAtAndInStatus('2020-01-01 00:00:00', '2020-04-01 00:00:00', [2, 3]));


////////////////////////////
/////////// Dz5 ////////////
////////////////////////////

//$ua = new Currency('UAH');
//$usd = new Currency('USD');
//
//$uaMoney = new Money(500, $ua);
//$uaMoney2 = new Money(300, $ua);
//$uaMoney3 = new Money(500, $ua);
//$usdMoney = new Money(100, $usd);
//
//
//if ($uaMoney->equals($uaMoney2)) {
//    echo "YES<br>";
//} else {
//    echo "NO<br>";
//}
//
//if ($uaMoney->equals($uaMoney3)) {
//    echo "YES<br>";
//} else {
//    echo "NO<br>";
//}
//
//if ($uaMoney->equals($usdMoney)) {
//    echo "YES<br>";
//} else {
//    echo "NO<br>";
//}
//
//
//echo $uaMoney->getAmount();
//$uaMoney->add($uaMoney2);
//echo "<br>" . $uaMoney->getAmount();
//
//$usdMoney->add($uaMoney);