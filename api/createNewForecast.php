<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$client = new GuzzleHttp\Client();
$res = $client->request('POST', 'https://api-sandbox.direct.yandex.ru/live/v4/json/', [
    'headers' => [
        'Host' => 'api-sandbox.direct.yandex.ru',
        'Authorization' => 'Bearer ' . getenv('ACCESS_TOKEN'),
        'Accept-Language' => 'ru',
        'Client-Login' => 'agrom',
        'Content-Type' => 'application/json; charset=utf-8',
        'Access-Control-Allow-Origin' => "*"
    ],
    'json' => [
        'method' => "CreateNewForecast",
        'locale' => 'ru',
        'token' => getenv('ACCESS_TOKEN'),
        'param' => [
            'Currency' => 'RUB',
            'Phrases' => [
                utf8_encode($_REQUEST['phrases'])
            ],
            'GeoID' => [$_REQUEST['region']],
            'AuctionBids' => 'Yes',
        ]
    ]
]);

$data = $res->getBody()->getContents();

echo $data;
