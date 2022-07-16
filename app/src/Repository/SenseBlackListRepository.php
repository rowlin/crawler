<?php

namespace App\Repository;

use App\Entity\Jobs;
use App\Entity\SenseBlackList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Traits\JobsTrait;
/**
 * @extends ServiceEntityRepository<SenseBlackList>
 *
 * @method SenseBlackList|null find($id, $lockMode = null, $lockVersion = null)
 * @method SenseBlackList|null findOneBy(array $criteria, array $orderBy = null)
 * @method SenseBlackList[]    findAll()
 * @method SenseBlackList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Jobs      getCurrentJob(int $id)
 */
class SenseBlackListRepository extends ServiceEntityRepository
{
    use JobsTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SenseBlackList::class);
    }

    public function add(SenseBlackList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SenseBlackList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SenseBlackList[] Returns an array of SenseBlackList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SenseBlackList
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
