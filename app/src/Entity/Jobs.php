<?php

namespace App\Entity;

use App\Repository\JobsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JobsRepository::class)
 */
class Jobs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private  int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @Assert\Blank()
     * @ORM\Column(type="string", length=60)
     */
    private string $name;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $code;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\OneToOne(targetEntity="BotChannel")
     * @ORM\JoinColumn(name="bot_channel_id", referencedColumnName="id" )
     */
    private  $channel;

    /**
     * @ORM\Column(type="string", length=16 , options={"default" = "* * * * *" } )
     */

    private string $cron;

    /**
     * @ORM\Column(type="integer" , options={"default" : 20})
     */
    private int $maxCount;

    /**
     * @ORM\OneToMany(targetEntity=JobResponse::class, mappedBy="job")
     */
    private Collection $job;

    /**
     * @ORM\OneToMany(targetEntity=SenseBlackList::class, mappedBy="jobs")
     */
    private $senseBlackLists;

    #[Pure]
    public function __construct()
    {
        $this->job = new ArrayCollection();
        $this->senseBlackLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getCron() : string
    {
        return $this->cron;
    }

    public function setCron($cron): self
    {
        $this->cron = $cron;
        return $this;
    }

    public function getMaxCount(): int
    {
        return $this->maxCount;
    }

    public function setMaxCount(int $maxCount): self
    {
        $this->maxCount = $maxCount;
        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel(?BotChannel $botchannel): self
    {
        $this->channel = $botchannel;
        return $this;
    }

    /**
     * @return Collection <JobResponse>
     */
    public function getJob(int $max ): Collection
    {
        /*if($max) {
            $criteria = \Doctrine\Common\Collections\Criteria::create()
                ->orderBy(array('date' => \Doctrine\Common\Collections\Criteria::DESC))
                ->setMaxResults(20);
            $res =  $this->job->matching($criteria);
        }else {
            $res  = $this->job;
        }*/
        return  $this->job;
    }


    public function addJob(JobResponse $job): self
    {
        if (!$this->job->contains($job)) {
            $this->job[] = $job;
            $job->setJob($this);
        }

        return $this;
    }

    public function removeJob(JobResponse $job): self
    {
        if ($this->job->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getJob() === $this) {
                $job->setJob(null);
            }
        }

        return $this;
    }


    public function getSenseBlackLists()
    {
       return $this->senseBlackLists;
    }

    public function addSenseBlackList(SenseBlackList $senseBlackList): self
    {
        if (!$this->senseBlackLists->contains($senseBlackList)) {
            $this->senseBlackLists[] = $senseBlackList;
            $senseBlackList->setJobs($this);
        }

        return $this;
    }

    public function removeSenseBlackList(SenseBlackList $senseBlackList): self
    {
        if ($this->senseBlackLists->removeElement($senseBlackList)) {
            // set the owning side to null (unless already changed)
            if ($senseBlackList->getJobs() === $this) {
                $senseBlackList->setJobs(null);
            }
        }

        return $this;
    }
}
