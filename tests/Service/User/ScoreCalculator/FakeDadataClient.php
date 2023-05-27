<?php

namespace App\Tests\Service\User\ScoreCalculator;

use App\API\Dadata\DadataClientInterface;
use App\Model\Dadata\DadataPhoneInfo;
use App\Service\User\ScoreCalculator\UserScoreService;

class FakeDadataClient implements DadataClientInterface
{
    public function getPhoneInfo(string $phone): ?DadataPhoneInfo
    {
        $dadataPhoneInfo = new DadataPhoneInfo();
        $dadataPhoneInfo->setProvider('ПАО "МегаФон"');

        return $dadataPhoneInfo;
    }
}