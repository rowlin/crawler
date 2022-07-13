<?php

namespace App\Entity;

use App\Repository\BotChannelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BotChannelRepository::class)
 */
class BotChannel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Bot")
     * @ORM\JoinColumn(nullable=false)
     */

    private $bots;


    /**
     * @ORM\ManyToOne(targetEntity="Channel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $channels;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBots()
    {
        return $this->bots;
    }

    public function setBots($bots): self
    {
        $this->bots = $bots;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChannels()
    {
        return $this->channels;
    }

    public function setChannels($channels): self
    {
        $this->channels = $channels;
        return  $this;
    }

}
