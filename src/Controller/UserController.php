<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER_READ")
 * @package App\Controller
 * @Route("/user")
 */
class UserController extends ApiAbstractController
{
    /** @var string */
    private const CREATED_SUCCESS = 'The user %s was successfully created';

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
    public function createUser(Request $request): JsonResponse
    {
        $request = $this->getRequestContent($request);
        $user = $this->userService->createUser($request);

        return $this->json([
            "message" => sprintf(self::CREATED_SUCCESS, $user->getName())
        ]);
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
