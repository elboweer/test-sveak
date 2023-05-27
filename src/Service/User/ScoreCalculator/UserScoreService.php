<?php

namespace App\Service\User\ScoreCalculator;

use App\API\Dadata\DadataClient;
use App\Entity\User\User;

class UserScoreService implements ScoreCalculateInterface
{
    public const MOBILE_PROVIDER_SCORE_TABLE = [
        'ПАО "Мобильные ТелеСистемы"' => 3,
        'ПАО "МегаФон"' => 10,
        'ПАО "Вымпел-Коммуникации"' => 5
    ];

    public const EDUCATION_SCORE_TABLE = [
        User::EDUCATION_TYPE_SCHOOL => 5,
        User::EDUCATION_TYPE_SPECIAL => 10,
        User::EDUCATION_TYPE_HIGHER => 15
    ];

    private DadataClient $dadataClient;

    public function __construct(DadataClient $dadataClient)
    {
        $this->dadataClient = $dadataClient;
    }

    public function calculateScore(User $user): int
    {
        $score = 0;
        $score += $this->getMailScore($user->getEmail());
        $score += $this->getPhoneScore($user);
        $score += $this->getEducationScore($user->getEducation());
        if ($user->isAgreedToPersonalDataCollect()) {
            $score += 4;
        }

        return $score;
    }

    public function explain(User $user): array
    {
        return [
            'email' => $this->getMailScore($user->getEmail()),
            'phone' => self::MOBILE_PROVIDER_SCORE_TABLE[$user->getOperator()] ?? 0,
            'education' => $this->getEducationScore($user->getEducation()),
            'PDC' => $user->isAgreedToPersonalDataCollect() ? 4 : 0,
        ];
    }

    protected function getMailScore(string $mail): int
    {
        if (str_contains($mail, '@gmail')) {
            return 10;
        }

        if (str_contains($mail, '@yandex')) {
            return 8;
        }

        if (str_contains($mail, '@mail')) {
            return 6;
        }

        return 3;
    }

    protected function getPhoneScore(User $user): int
    {
        if (!$dadataPhoneInfo = $this->dadataClient->getPhoneInfo($user->getPhone())) {
            return 0;
        }

        $user->setOperator($dadataPhoneInfo->getProvider());

        return self::MOBILE_PROVIDER_SCORE_TABLE[$dadataPhoneInfo->getProvider()] ?? 0;
    }

    protected function getEducationScore(string $education): int
    {
        return self::EDUCATION_SCORE_TABLE[$education] ?? 0;
    }
}