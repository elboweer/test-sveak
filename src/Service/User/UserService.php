<?php

namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Throwable;


class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function storeUser(User $user): bool
    {
        $this->userRepository->save($user, true);

        return true;
    }

    public function getUser(int $userID): ?User
    {
        try {
            if (!$user = $this->userRepository->getByID($userID)) {
                return null;
            }
        } catch (Throwable) {
            return null;
        }

        return $user;
    }

    public function getTotalUserCount(): int
    {
        return $this->userRepository->getTotalUserCount();
    }

    public function getUserList(int $page, int $limit): array
    {
        return $this->userRepository->getUserList($page, $limit);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}