<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$client = new GuzzleHttp\Client();
$res = $client->request('POST', 'https://api-sandbox.direct.yandex.ru/v4/json/', [
    'headers' => [
        'Host' => 'api-sandbox.direct.yandex.ru',
        'Authorization' => 'Bearer ' . getenv('ACCESS_TOKEN'),
        'Accept-Language' => 'ru',
        'Client-Login' => 'agrom',
        'Content-Type' => 'application/json; charset=utf-8',
        'Access-Control-Allow-Origin' => "*"
    ],
    'json' => [
        'method' => "GetRegions",
        'locale' => 'ru',
        'token' => getenv('ACCESS_TOKEN')
    ]
]);

$data = [];
$regions = json_decode($res->getBody()->getContents())->data;

foreach ($regions as $region) {
    $data[] = [
        'label' => $region->RegionName,
        'value' => $region->RegionID,
    ];
}

$label = array_column($data, 'label');
$value = array_column($data, 'value');

array_multisort($label, SORT_ASC, $data);

echo json_encode($data);
