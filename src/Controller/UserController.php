<?php

namespace App\Controller;

use App\Service\UserService;
use Doctrine\ORM\NonUniqueResultException;
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
    private const MESSAGE_SUCCESS = 'The user %s was successfully %s';

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

        return $this->json(["message" => sprintf(self::MESSAGE_SUCCESS, $user->getUsername(), 'created')]);
    }

    /**
     * @IsGranted("ROLE_USER_ADMIN")
     * @Route("/delete/id/{id}", name="user_delete", methods={"GET"})
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function deleteUser(Request $request, int $id): JsonResponse
    {
        $request = $this->getRequestContent($request);
        $user = $this->userService->deleteUser($id, $request);

        return $this->json(["message" => sprintf(self::MESSAGE_SUCCESS, $user->getUsername(), 'deleted')]);
    }

    /**
     * @IsGranted("ROLE_USER_ADMIN")
     * @Route("/set-roles", name="user_set_roles", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function setRoles(Request $request): JsonResponse
    {
        $request = $this->getRequestContent($request);
        $user = $this->userService->setUserRoles($request);

        return $this->json(["message" => sprintf(self::MESSAGE_SUCCESS, $user->getUsername(), 'updated')]);
    }
}
