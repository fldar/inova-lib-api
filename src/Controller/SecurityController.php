<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /** @var string  */
    public const
        UNATHORIZED    = 'Please login to continue.',
        LOGIN_SUCCESS  = 'Welcome %s',
        LOGOUT_SUCCESS = 'Good By!'
    ;

    /**
     * @Route("/unauthorized", name="unauthorized", methods={"GET"})
     * @return JsonResponse
     */
    public function unauthorized(): JsonResponse
    {
        return $this->json(['message' => self::UNATHORIZED]);
    }

    /**
     * @Route("/login", name="login", methods={"POST", "GET"})
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json(['message' => sprintf(self::LOGIN_SUCCESS, $user->getName())]);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout(): void
    {
    }

    /**
     * @Route("/logouted", name="logouted", methods={"GET"})
     * @return JsonResponse
     */
    public function logouted(): JsonResponse
    {
        return $this->json(['message' => self::LOGOUT_SUCCESS]);
    }

    /**
     * @Route("/check", name="check", methods={"GET"})
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        return $this->json(true);
    }
}
