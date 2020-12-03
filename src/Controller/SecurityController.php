<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/logout", name="api_logout", methods={"GET"})
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
        return $this->json(['message' => 'Good Bye!']);
    }

    /**
     * @Route("/check", name="check", methods={"GET"})
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        return $this->json(['message' => "Hello!"]);
    }
}
