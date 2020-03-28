<?php

require __DIR__ . "/../vendor/autoload.php";

use Islambey\Xapiand\Xapiand;

$xapiand = new Xapiand("http://0.0.0.0:8880");

$result = $xapiand->document()->info("employee", "dcd46b6c-826a-372d-8c92-7825b4387196");

var_dump($result);

