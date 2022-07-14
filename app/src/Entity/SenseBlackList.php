<?php

namespace App\Entity;

use App\Repository\SenseBlackListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SenseBlackListRepository::class)
 */
class SenseBlackList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $sense;

    /**
     * @ORM\ManyToOne(targetEntity=Jobs::class, inversedBy="senseBlackLists")
     */
    private $jobs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSense(): ?string
    {
        return $this->sense;
    }

    public function setSense(string $sense): self
    {
        $this->sense = $sense;

        return $this;
    }

    public function getJobs(): ?Jobs
    {
        return $this->jobs;
    }

    public function setJobs(?Jobs $jobs): self
    {
        $this->jobs = $jobs;

        return $this;
    }
}
