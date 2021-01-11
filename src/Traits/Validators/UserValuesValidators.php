<?php

namespace App\Traits\Validators;

use App\Entity\User;
use App\Repository\UserRepository;

trait UserValuesValidators
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User|null $user
     */
    public function validUserEntity(?User $user): void
    {
        if (!$user || !$user->getId()) {
            throw new \DomainException('Invalid User!');
        }
    }

    /**
     * @param string|null $name
     */
    public function validName(?string $name): void
    {
        if (!$name) {
            throw new \DomainException('name required.');
        }
    }

    /**
     * @param string|null $username
     * @param bool|null $validUniq
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validUserName(?string $username, ?bool $validUniq = true): void
    {
        if (!$username) {
            throw new \DomainException('username required.');
        }

        if ($validUniq) {
            $this->validUsernameAvailable($username);
        }
    }

    /**
     * @param string $username
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validUsernameAvailable(string $username): void
    {
        $user = $this->userRepository->findIdByUsername($username);

        if ($user) {
            throw new \DomainException('username already used.');
        }
    }

    /**
     * @param string|null $email
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validEmail(?string $email): void
    {
        if (!$email) {
            throw new \DomainException('email required.');
        }

        $this->validEmailAvailable($email);
    }

    /**
     * @param string $email
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validEmailAvailable(string $email): void
    {
        $user = $this->userRepository->findIdByEmail($email);

        if ($user) {
            throw new \DomainException('Email already used.');
        }
    }
}
