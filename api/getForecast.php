<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$client = new GuzzleHttp\Client();

$data = null;
while (is_null($data)) {
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
            'method' => "GetForecast",
            'locale' => 'ru',
            'token' => getenv('ACCESS_TOKEN'),
            'param' => $_REQUEST['id']
        ]
    ]);

    $data = json_decode($res->getBody()->getContents())->data;

    sleep(2);
}

echo json_encode($data);
