<?php

namespace App\Controller;

use App\Service\RecoverPasswordService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @package App\Controller
 * @Route("/recover-password")
 */
class RecoverPasswordController extends ApiAbstractController
{
    /** @var string */
    private const MESSAGE_SUCCESS = 'Password change request sent, check your email.';

    private RecoverPasswordService $service;

    /**
     * @param RecoverPasswordService $recoverPasswordService
     */
    public function __construct(RecoverPasswordService $recoverPasswordService)
    {
        $this->service = $recoverPasswordService;
    }

    /**
     * @Route("/send", name="send_password_recover", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function sendRequestRecover(Request $request): JsonResponse
    {
        $request = $this->getRequestContent($request);
        $this->service->sendRequestRecover($request);

        return $this->json(['message' => self::MESSAGE_SUCCESS]);
    }
}
