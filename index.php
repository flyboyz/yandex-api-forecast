<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use directapi\DirectApiService;
use directapi\services\campaigns\criterias\CampaignsSelectionCriteria;
use directapi\services\campaigns\enum\CampaignStateEnum;
use directapi\services\campaigns\enum\CampaignFieldEnum;

$loader = require __DIR__ . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$directApiService = new DirectApiService(getenv('ACCESS_TOKEN'), getenv('LOGIN'));
$criteria = new CampaignsSelectionCriteria();
$criteria->States = [CampaignStateEnum::ON];
$campaigns = $directApiService->getCampaignsService()->get($criteria, CampaignFieldEnum::getValues());

var_dump($campaigns);

/*
use Biplane\YandexDirect\Api\V5\Contract\AdFieldEnum;
use Biplane\YandexDirect\Api\V5\Contract\AdsSelectionCriteria;
use Biplane\YandexDirect\Api\V5\Contract\GetAdsRequest;
use Biplane\YandexDirect\Api\V5\Contract\StateEnum;
use Biplane\YandexDirect\Api\V4\Contract\NewForecastInfo;
use Biplane\YandexDirect\User;

$user = new User([
    'access_token' => getenv('ACCESS_TOKEN'),
    'login' => getenv('LOGIN'),
    'locale' => User::LOCALE_RU,
]);

$params = NewForecastInfo::create()
    ->setCurrency('RUB')
    ->setPhrases(['test']);

$response = $user->getApiService()->createNewForecast($params);

var_dump($response); die();
*/

