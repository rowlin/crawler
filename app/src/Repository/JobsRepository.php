<?php

namespace App\Repository;

use App\Entity\Bot;
use App\Entity\BotChannel;
use App\Entity\Channel;
use App\Entity\Jobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Jobs>
 *
 * @method Jobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jobs[]    findAll()
 * @method Jobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jobs::class);
    }

    public function add(Jobs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getAll(bool $active) :array{
        $qb = $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->setParameter('active', $active)
            ->orderBy('p.id', 'DESC');
        $query = $qb->getQuery();
        return  $query->execute();
    }

    public function remove(Jobs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function addBotChannel($bot_id  , $channel_id ){
        $bot = $this->getEntityManager()->getRepository(Bot::class)->find($bot_id);
        $channel =  $this->getEntityManager()->getRepository(Channel::class)->find($channel_id);
        $bot_channel = $this->getEntityManager()->getRepository(BotChannel::class)->findOneBy(['bots_id' => $bot_id , 'channels_id' => $channel_id]);
        if($bot_channel == null) {
            $bot_channel = new BotChannel();
            $bot_channel->setChannels($channel);
            $bot_channel->setBots($bot);
            $this->getEntityManager()->getRepository(BotChannel::class)->add($bot_channel, true);
        }
        return $bot_channel;
    }


//    /**
//     * @return Jobs[] Returns an array of Jobs objects
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

//    public function findOneBySomeField($value): ?Jobs
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }JobResponse

}
