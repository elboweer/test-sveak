<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CustomAbstractController extends AbstractController
{
    public function returnTemplatedError(int $statusCode, ?string $msg = null): Response {
        return $this->render('core/error.html.twig', [
            'statusCode' => $statusCode,
            'msg' => $msg
        ]);
    }
}