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
     * @param UserPasswordEncoderInterface $passwordEncoder
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

        $user->setName($data->get('name'))
            ->setEmail($data->get('email'))
            ->setUsername($data->get('username'))
            ->setCreatedAt()
            ->setUpdatedBy($data->get('user_logged'))
            ->setPassword($this->getEncondePassword($user, $data))
        ;

        return $this->userRepository->createUser($user);
    }

    /**
     * @param User $user
     * @param ArrayCollection $data
     * @return string
     */
    private function getEncondePassword(User $user, ArrayCollection $data): string
    {
        return $this->passwordEncoder->encodePassword($user, $data->get('password'));
    }

    /**
     * @param int|null $id
     * @param ArrayCollection $request
     * @return int
     */
    public function deleteUser(?int $id, ArrayCollection $request): int
    {
        $user = $this->userRepository->findById($id);
        dd($user);
//        $this->userRepository->deleteUser($id);
    }
}
