<?php
/**
 * Before running this script install fzaninotto/faker
 * composer require fzaninotto/faker --dev
 */

require __DIR__ . "/../vendor/autoload.php";

$xapiand = new Islambey\Xapiand\Xapiand("http://0.0.0.0:8880");
$faker = Faker\Factory::create();
$amount = 50_000;

for ($i = 0; $i < $amount; $i++) {
    $document = [
        "name" => $faker->name,
        "city" => $faker->city,
        "company" => $faker->company,
        "title" => $faker->jobTitle,
        "email" => $faker->email,
        "user_agent" => $faker->userAgent,
        "country" => $faker->country,
    ];

    $xapiand->document()->index("employee", $faker->uuid, $document);
}

echo "DONE\n";
