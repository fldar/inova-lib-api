<?php

namespace App\Service;

use Carbon\Carbon;
use App\Entity\User;
use App\Entity\UserRecover;
use App\Repository\UserRecoverRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Traits\Validators\UserValuesValidators;

class RecoverPasswordService
{
    use UserValuesValidators;

    private UserRepository $userService;
    private UserRecoverRepository $userRecoverRepository;

    /**
     * @param UserRepository $userRepository
     * @param UserRecoverRepository $userRecoverRepository
     */
    public function __construct(
        UserRepository $userRepository,
        UserRecoverRepository $userRecoverRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userRecoverRepository = $userRecoverRepository;
    }

    /**
     * @param ArrayCollection $data
     * @return UserRecover
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function sendRequestRecover(ArrayCollection $data): UserRecover
    {
        $this->validUserName($data->get('username'), false);

        $username = $data->get('username');
        $user = $this->userRepository->loadUserByUsername($username);

        $this->validUserEntity($user);

        $userHash = $this->hashFactory($user);

        $this->userRecoverRepository->createHash($userHash);

        return $userHash;
    }

    /**
     * @param User $user
     * @return UserRecover
     */
    private function hashFactory(User $user): UserRecover
    {
        $userHash = new UserRecover();
        $userHash->setHash($this->hashGen($user));
        $userHash->setCreatedAt(Carbon::now());
        $userHash->setUser($user);

        return $userHash;
    }

    /**
     * @param User $user
     * @return string
     */
    private function hashGen(User $user): string
    {
        return md5(
            Carbon::now()->format('YmdHi') .
            $user->getUsername() .
            $user->getCreatedAt()->format('YmdHi')
        );
    }
}
