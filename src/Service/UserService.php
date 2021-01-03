<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private UserRepository $userRepository;
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return ArrayCollection
     */
    public function getAllUser(): ArrayCollection
    {
        return new ArrayCollection($this->userRepository->findAll());
    }

    /**
     * @param ArrayCollection $data
     * @return User
     */
    public function createUser(ArrayCollection $data): User
    {
        $user = new User();

        $password = $this->passwordEncoder
            ->encodePassword($user, $data->get('password'))
        ;

        $user->setName($data->get('name'));
        $user->setEmail($data->get('email'));
        $user->setUsername($data->get('username'));
        $user->setPassword($password);

        return $this->userRepository->createUser($user);
    }
}
