<?php

namespace App\Repository;

use App\Entity\SentResponse;
use App\Traits\JobsTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SentResponse>
 *
 * @method SentResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method SentResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method SentResponse[]    findAll()
 * @method SentResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentResponseRepository extends ServiceEntityRepository
{
    use JobsTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SentResponse::class);
    }

    public function add(SentResponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SentResponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SentResponse[] Returns an array of SentResponse objects
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

//    public function findOneBySomeField($value): ?SentResponse
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
