<?php

namespace App\Service;

use Carbon\Carbon;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Common\Collections\ArrayCollection;
use App\Traits\Validators\UserValues as UserValuesValidators;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    use UserValuesValidators;

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
     * @throws NonUniqueResultException
     */
    public function createUser(ArrayCollection $data): User
    {
        $user = new User();

        $this->validName($data->get('name'));
        $this->validEmail($data->get('email'));
        $this->validUserName($data->get('username'));

        $user->setName($data->get('name'))
            ->setEmail($data->get('email'))
            ->setUsername($data->get('username'))
            ->setCreatedAt()
            ->setUpdatedBy($data->get('user_logged'))
            ->setPassword($this->getEncondePassword($user, $data))
        ;

        return $this->userRepository->saveUser($user);
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
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function getById(?int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * @param int|null $id
     * @param ArrayCollection $request
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function deleteUser(?int $id, ArrayCollection $request): ?User
    {
        $user = $this->getById($id);

        $this->validUserEntity($user);

        $user->setDeletedAt(Carbon::now());
        $user->setUpdatedBy($request->get('user_logged'));
        $this->userRepository->saveUser($user);

        return $user;
    }

    /**
     * @param ArrayCollection $request
     * @throws NonUniqueResultException
     */
    public function setUserRoles(ArrayCollection $request): User
    {
        $user = $this->getById($request->get('id'));

        $this->validUserEntity($user);
        $user->setRoles($request->get('roles') ?? []);
        $user->setUpdatedAt(Carbon::now());
        $user->setUpdatedBy($request->get('user_logged'));
        $this->userRepository->saveUser($user);

        return $user;
    }
}
