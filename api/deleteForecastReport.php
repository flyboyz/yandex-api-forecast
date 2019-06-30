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
        'method' => "DeleteForecastReport",
        'token' => getenv('ACCESS_TOKEN'),
        'param' => $_REQUEST['id'],
    ]
]);

echo json_decode($res->getBody()->getContents())->data;
