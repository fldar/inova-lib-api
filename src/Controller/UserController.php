<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER_READ")
 * @package App\Controller
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/list", name="user_list", methods={"GET"})
     * @return JsonResponse
     */
    public function listUsers(): JsonResponse
    {
        return $this->json([$this->userService->getAllUser()]);
    }

    /**
     * @IsGranted("ROLE_USER_WRITE")
     * @Route("/create", name="user_create", methods={"POST"})
     * @return JsonResponse
     */
    public function createUser(): JsonResponse
    {
        return $this->json(["bla"]);
    }

    /**
     * @IsGranted("ROLE_USER_ADMIN")
     * @Route("/delete", name="user_delete", methods={"POST"})
     * @return JsonResponse
     */
    public function deleteUser(): JsonResponse
    {
        return $this->json(["bla"]);
    }
}
