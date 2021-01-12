<?php

namespace App\Service;

use Carbon\Carbon;
use App\Entity\User;
use App\Entity\UserRecover;
use App\Repository\UserRecoverRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Traits\Validators\{UserValuesValidators, UserRecoverValuesValidators};

class RecoverPasswordService
{
    use UserValuesValidators;
    use UserRecoverValuesValidators;

    private UserRepository $userRepository;
    private UserRecoverRepository $userRecoverRepository;
    private UserService $userService;

    /**
     * @param UserRepository $userRepository
     * @param UserRecoverRepository $userRecoverRepository
     * @param UserService $userService
     */
    public function __construct(
        UserRepository $userRepository,
        UserRecoverRepository $userRecoverRepository,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userRecoverRepository = $userRecoverRepository;
        $this->userService = $userService;
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
        $this->invalidOldHashes($user);

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

        $userHash
            ->setHash($this->hashGen($user))
            ->setCreatedAt(Carbon::now())
            ->setUser($user)
        ;

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
            uniqid()
        );
    }

    /**
     * @param User $user
     * @return int|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function invalidOldHashes(User $user): ?int
    {
        return $this->userRecoverRepository->useUserHashes($user);
    }

    /**
     * @param string $token
     * @param ArrayCollection $data
     */
    public function changePassword(string $token, ArrayCollection $data): void
    {
        $userRecover = $this->userRecoverRepository->findByHash($token);

        $this->validUserRecoverEntity($userRecover);
        $this->validPassword($data->get('password'));

        $user = $userRecover->getUser();
        $password = $this->userService->getEncondePassword($user, $data);

        $user->setPassword($password);

        $this->userRepository->saveUser($user);
        $this->invalidOldHashes($user);
    }
}
