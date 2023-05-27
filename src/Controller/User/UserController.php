<?php

namespace App\Controller\User;

use App\API\Dadata\DadataClient;
use App\Controller\CustomAbstractController;
use App\Entity\User\User;
use App\Form\User\UserRegisterType;
use App\Service\User\ScoreCalculator\UserScoreService;
use App\Service\User\UserService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UserController extends CustomAbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/register', name: 'user_register')]
    public function register(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->userService->storeUser($user)) {
            return $this->redirectToRoute('user_edit_profile', [
                'userId' => $user->getId()
            ]);
        }

        return $this->render('user/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/profile/edit/{userId}', name: 'user_edit_profile')]
    public function profileEdit(int $userId, Request $request): Response
    {
        if (!$user = $this->userService->getUser($userId)) {
            return $this->returnTemplatedError(Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        $success = false;
        if ($form->isSubmitted() && $form->isValid() && $this->userService->storeUser($user)) {
            $success = true;
        }

        return $this->render('user/register.html.twig', [
            'user' => $user,
            'form' => $form,
            'success' => $success
        ]);
    }

    #[Route('/profile/{userId}', name: 'user_profile')]
    public function profile(int $userId): Response
    {
        if (!$user = $this->userService->getUser($userId)) {
            return $this->returnTemplatedError(Response::HTTP_NOT_FOUND);
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/list', name: 'user_list')]
    public function list(Request $request): Response
    {
        $page = $request->query->get('page') ?? 1;
        $limit = $this->getParameter('user_list_paginator_limit');

        return $this->render('user/list.html.twig', [
            'page' => $page,
            'limit' => $limit,
            'totalCount' => $this->userService->getTotalUserCount(),
            'users' => $this->userService->getUserList($page, $limit)
        ]);
    }
}