<?php

require __DIR__ . "/../vendor/autoload.php";

use Islambey\Xapiand\Xapiand;

$xapiand = new Xapiand("http://0.0.0.0:8880");

dump($xapiand->getServerInfo());
