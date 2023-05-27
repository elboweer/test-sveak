<?php

namespace App\API\Dadata;

use App\Model\Dadata\DadataPhoneInfo;

interface DadataClientInterface
{
    public function getPhoneInfo(string $phone): ?DadataPhoneInfo;
}