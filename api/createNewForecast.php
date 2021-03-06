<?php
$loader = require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$client = new GuzzleHttp\Client();
$res = $client->request('POST', 'https://api.direct.yandex.ru/live/v4/json/', [
    'headers' => [
        'Host' => 'api.direct.yandex.ru',
        'Authorization' => 'Bearer ' . getenv('ACCESS_TOKEN'),
        'Accept-Language' => 'ru',
        'Content-Type' => 'application/json; charset=utf-8',
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

$forecastId = json_decode($res->getBody()->getContents())->data;

echo $forecastId ? $forecastId : 0;
