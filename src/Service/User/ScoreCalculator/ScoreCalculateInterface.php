<?php

namespace App\Service\User\ScoreCalculator;

use App\Entity\User\User;

interface ScoreCalculateInterface
{
    public function calculateScore(User $user): int;
}