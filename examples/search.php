<?php
require __DIR__ . "/../vendor/autoload.php";

use Islambey\Xapiand\Xapiand;

$xapiand = new Xapiand("http://0.0.0.0:8880");

var_dump(
    $xapiand->search("employee", [
        "_query" => [
            "_or" => [
                ["name" => "Frank"],
                ["title" => "social"],
            ]
        ],
        "_limit" => 25,
    ])
);