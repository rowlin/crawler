<?php

namespace App\Entity;

use App\Repository\JobsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
    private  $id;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @Assert\Blank()
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_date;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=16 , options={"default" = "* * * * *" } )
     */

    private $cron;

    public function getCron() : string
    {
        return $this->cron;
    }

    public function setCron($cron): void
    {
        $this->cron = $cron;
    }

    /**
     * @ORM\OneToMany(targetEntity=JobResponse::class, mappedBy="job")
     */
    private $job;

    public function __construct()
    {
        $this->job = new ArrayCollection();
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

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

    /**
     * @return Collection <JobResponse>
     */
    public function getJob(int $max ): Collection
    {
        if($max) {
            $criteria = \Doctrine\Common\Collections\Criteria::create()
                ->orderBy(array('date' => \Doctrine\Common\Collections\Criteria::DESC))
                ->setMaxResults(20);
            $res =  $this->job->matching($criteria);
        }else {
            $res  = $this->job;
        }
        return  $res;
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
}
