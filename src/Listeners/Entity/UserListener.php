<?php

namespace App\Listeners\Entity;

use App\Entity\User\User;
use App\Service\User\ScoreCalculator\UserScoreService;
use Doctrine\ORM\Event\PreFlushEventArgs;

class UserListener
{
    private UserScoreService $scoreService;

    public function __construct(UserScoreService $scoreService)
    {
        $this->scoreService = $scoreService;
    }

    public function preFlush(User $user, PreFlushEventArgs $event): void
    {
        try {
            $user->setScore($this->scoreService->calculateScore($user));
            $event->getObjectManager()->persist($user);
        } catch (\Throwable) {

        }
    }
}