<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\AuthenticationRequiredException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /** @var string  */
    public const
        LOGIN_SUCCESS  = 'Welcome %s',
        LOGOUT_SUCCESS = 'Good By!'
    ;

    /**
     * @Route("/unauthorized", name="unauthorized", methods={"GET"})
     */
    public function unauthorized(): void
    {
        throw new AuthenticationRequiredException();
    }

    /**
     * @Route("/login", name="login", methods={"POST", "GET"})
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        /** @var User $user */
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
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/check", name="check", methods={"GET"})
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        return $this->json(true);
    }
}
