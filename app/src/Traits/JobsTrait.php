<?php


namespace App\Traits;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Jobs;
use App\Exception\NotFoundException;

trait JobsTrait
{

    /**
     * Entity manager to use to look up projects.
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @required
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCurrentJob(int $id) : Jobs{
        $job =  $this->entityManager->getRepository(Jobs::class)->find($id);
        if(!$job)
            throw new  NotFoundException;
        return $job;
    }
}
