<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Traits\Validators\UserValuesValidators;

class RecoverPasswordService
{
    use UserValuesValidators;

    private UserRepository $userService;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ArrayCollection $data
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function sendRequestRecover(ArrayCollection $data)
    {
        $this->validUserName($data->get('username'), false);

        $username = $data->get('username');
        $user = $this->userRepository->loadUserByUsername($username);

        $this->validUserEntity($user);

        dd($user);
    }
}
