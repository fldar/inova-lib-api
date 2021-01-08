<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\{ORMException, OptimisticLockException, NonUniqueResultException};
use Symfony\Component\Security\Core\{
    User\UserInterface,
    User\PasswordUpgraderInterface,
    Exception\UnsupportedUserException
};

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param UserInterface $user
     * @param string $newEncodedPassword
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);

        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param string $username
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername(string $username): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :username')
            ->orWhere('u.username = :username')
            ->andWhere('u.deletedAt IS NULL')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.id', 'u.name', 'u.email', 'u.username', 'u.roles')
            ->where('u.deletedAt IS NULL')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param User $user
     * @return User
     */
    public function saveUser(User $user): User
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    /**
     * @param int|null $id
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function findById(?int $id)
    {
        if (!$id) {
            return null;
        }

        return $this->createQueryBuilder('u')
            ->where('u.id = :id')
            ->andWhere('u.deletedAt IS NULL')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param string $email
     * @return int|null
     * @throws NonUniqueResultException
     */
    public function findIdByEmail(string $email): ?int
    {
        $result = $this->createQueryBuilder('u')
            ->select('u.id')
            ->where('u.email = :email')
            ->andWhere('u.deletedAt IS NULL')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $result ? $result['id'] : null;
    }

    /**
     * @param string $username
     * @return int|null
     * @throws NonUniqueResultException
     */
    public function findIdByUsername(string $username): ?int
    {
        $result = $this->createQueryBuilder('u')
            ->select('u.id')
            ->where('u.username = :username')
            ->andWhere('u.deletedAt IS NULL')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $result ? $result['id'] : null;
    }
}
