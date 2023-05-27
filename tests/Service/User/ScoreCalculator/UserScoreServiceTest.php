<?php

namespace App\Tests\Service\User\ScoreCalculator;

use App\Entity\User\User;
use App\Service\User\ScoreCalculator\UserScoreService;
use PHPUnit\Framework\TestCase;
class UserScoreServiceTest extends TestCase
{
    /** @test */
    public function calculateScoreTest(): void
    {
        $user = new User();
        $user->setPhone("79953134512");
        $user->setEducation(User::EDUCATION_TYPE_HIGHER);
        $user->setEmail("test@yandex.ru");
        $user->setAgreedToPersonalDataCollect(true);

        $userScoreService = new UserScoreService(new FakeDadataClient());
        $this->assertEquals(37, $userScoreService->calculateScore($user));
    }
}
