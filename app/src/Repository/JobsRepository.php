<?php

namespace App\Repository;

use App\Entity\Bot;
use App\Entity\BotChannel;
use App\Entity\Channel;
use App\Entity\Jobs;
use App\Exception\NotFoundException;
use App\Exception\ValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Traits\JobsTrait;
/**
 * @extends ServiceEntityRepository<Jobs>
 *
 * @method Jobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jobs[]    findAll()
 * @method Jobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Jobs      getCurrentJob(int $id)
 */
class JobsRepository extends ServiceEntityRepository
{
    use JobsTrait;

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

    /**
     * @param int $bot_id
     * @param int $channel_id
     * @return BotChannel
     * !!! That is no good solution
     */

    public function addBotChannel(int $bot_id  , int $channel_id ) : BotChannel{
        $bot = $this->getEntityManager()->getRepository(Bot::class)->find($bot_id);
        if(!$bot){
            throw new ValidationException('That Bot not found');
        }
        $channel =  $this->getEntityManager()->getRepository(Channel::class)->find($channel_id);
        if(!$channel){
            throw new NotFoundException('That Channel not found');
        }
            $bot_channel = new BotChannel();
            $bot_channel->setChannels($channel);
            $bot_channel->setBots($bot);
        $this->getEntityManager()->getRepository(BotChannel::class)->add($bot_channel, true);
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
