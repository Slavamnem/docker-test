<?php

phpinfo();

$pdo = new PDO("pgsql:host=db;dbname=docker_test;port=5432", 'root', 'slava1234');

print_r($pdo);

$a = 5;

$a+= 4;

echo $a;