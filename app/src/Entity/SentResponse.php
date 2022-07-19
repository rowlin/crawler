<?php

namespace App\Entity;

use App\Repository\SentResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SentResponseRepository::class)
 */
class SentResponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Jobs::class, inversedBy="sentResponses")
     * @ORM\JoinColumn(name="job_id", nullable=false)
     */
    private $job_id;

    /**
     *  @ORM\Column(name="created_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */

    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getJobId(): ?Jobs
    {
        return $this->job_id;
    }

    public function setJobId(?Jobs $job_id): self
    {
        $this->job_id = $job_id;

        return $this;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->created_at;
    }
    /*
    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }
    */

}
