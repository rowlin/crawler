<?php

namespace App\Repository;

use App\Entity\Bot;
use App\Entity\BotChannel;
use App\Entity\Channel;
use App\Entity\JobResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobResponse::class);
    }

    public function addBotChannel($bot_id  , $channel_id ){
        $bot = $this->getEntityManager()->getRepository(Bot::class)->find($bot_id);
        $channel =  $this->getEntityManager()->getRepository(Channel::class)->find($channel_id);
        $bot_channel = $this->getEntityManager()->getRepository(BotChannel::class)->findBy(['bots_id' => $bot_id , 'channels_id' => $channel_id]);
        if($bot_channel == null) {
            $bot_channel = new BotChannel();
            $bot_channel->setChannels($channel);
            $bot_channel->setBots($bot);
            $this->getEntityManager()->getRepository(BotChannel::class)->add($bot_channel, true);
        }
        return $bot_channel;
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
