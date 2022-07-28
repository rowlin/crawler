<?php

namespace App\Entity;

use App\Repository\BotButtonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=BotButtonsRepository::class)
 */
class BotButtons
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $callback;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Bot::class, inversedBy="Bot")
     */
    private $bot;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id) : self{
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

    public function getCallback(): ?string
    {
        return $this->callback;
    }

    public function setCallback(string $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function getBotId(): ?Bot
    {
        return $this->bot;
    }

    public function setBotId(?Bot $bot_id): self
    {
        $this->bot = $bot_id;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
