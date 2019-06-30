<?php
$loader = require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$client = new GuzzleHttp\Client();

$countOfRequest = 0;
$forecastData = null;
while (is_null($forecastData) && $countOfRequest < 10) {
    $res = $client->request('POST', 'https://api.direct.yandex.ru/live/v4/json/', [
        'headers' => [
            'Host' => 'api.direct.yandex.ru',
            'Authorization' => 'Bearer ' . getenv('ACCESS_TOKEN'),
            'Accept-Language' => 'ru',
            'Content-Type' => 'application/json; charset=utf-8',
        ],
        'json' => [
            'method' => "GetForecast",
            'locale' => 'ru',
            'token' => getenv('ACCESS_TOKEN'),
            'param' => $_REQUEST['id']
        ]
    ]);

    $countOfRequest++;
    $forecastData = json_decode($res->getBody()->getContents())->data;
    if (!is_null($forecastData)) {
        $auctionBids = $forecastData->Phrases[0]->AuctionBids;
        foreach ($auctionBids as $auctionBid) {
            if ($auctionBid->Position === 'P12') {
                $price = $auctionBid->Price;
                break;
            }
        }

        $forecastData = [
            'clicks' => round($forecastData->Common->PremiumClicks),
            'price' => isset($price) ? round($price) : 0,
        ];
    } else {
        sleep(1.5);
    }
}

echo json_encode($forecastData);
