<?php

namespace App\Repository;

use App\Entity\UserRecover;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method UserRecover|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRecover|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRecover[]    findAll()
 * @method UserRecover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRecoverRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRecover::class);
    }

    /**
     * @param UserRecover $hash
     * @return UserRecover
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createHash(UserRecover $hash): UserRecover
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($hash);
        $entityManager->flush();

        return $hash;
    }
}
