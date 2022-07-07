<?php

namespace App\Entity;

use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 */
class Channel
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
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $chat_id;

    /**
     * @ORM\OneToMany(targetEntity=BotChannel::class, mappedBy="channels")
     */
    private $bots;

    public function __construct()
    {
        //$this->bot_id = new ArrayCollection();
    }

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

    public function getChatId(): ?string
    {
        return $this->chat_id;
    }

    public function setChatId(string $chat_id): self
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    public function getBots(): Collection
    {
        return $this->bots;
    }

    public function addBots(Bot $botId): self
    {
        if (!$this->bots->contains($botId)) {
            $this->bots[] = $botId;
        }

        return $this;
    }

    public function removeBot(Bot $botId): self
    {
        $this->bots->removeElement($botId);

        return $this;
    }
}
