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