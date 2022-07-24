<?php

namespace App\Repository;

use App\Entity\JobResponse;
use App\Entity\Jobs;
use App\Traits\JobsTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobResponse>
 *
 * @method JobResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobResponse[]    findAll()
 * @method JobResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobResponseRepository extends ServiceEntityRepository
{
    use JobsTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobResponse::class);
    }

    public function removeIfMore(Jobs $job){
        $rms = new ResultSetMapping($this->getEntityManager());
        $sql = "DELETE FROM job_response WHERE job_id = :job_id AND id NOT IN (SELECT  * FROM (SELECT  id FROM job_response where job_id = :job_id ORDER BY date DESC LIMIT :maxCount)temp );";
        $query =  $this->getEntityManager()->createNativeQuery($sql , $rms)
            ->setParameter('job_id' , $job->getId())
            ->setParameter('maxCount' , $job->getMaxCount() );
        return $query->getResult();
    }

    public function add(JobResponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobResponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JobResponse[] Returns an array of JobResponse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobResponse
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
