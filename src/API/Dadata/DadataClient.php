<?php

namespace App\API\Dadata;

use App\Model\Dadata\DadataPhoneInfo;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

const PHONE_URL = 'https://cleaner.dadata.ru/api/v1/clean/phone';
class DadataClient
{
    private string $apiKey;
    private string $secret;
    private HttpClientInterface $client;

    public function __construct(string $apiKey, string $secret, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->secret = $secret;
        $this->client = $client;
    }

    public function getPhoneInfo(string $phone): ?DadataPhoneInfo
    {
        try {
            $response = $this->client->request('POST', PHONE_URL, [
                'headers' => $this->getHeaders(),
                'json'  => [$phone]
            ])->getContent();
            $serializer = new Serializer([new GetSetMethodNormalizer()], ['json' => new JsonEncoder()]);
            $dadataPhoneInfo = $serializer->decode($response, 'json');

            return $serializer->denormalize($dadataPhoneInfo[0], DadataPhoneInfo::class);
        } catch (Throwable $throwable) {
        }

        return null;
    }

    private function getHeaders(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => "Token " . $this->apiKey,
            'X-Secret' => $this->secret
        ];
    }
}