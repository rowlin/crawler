<?php

namespace App\Entity;

use App\Repository\BotRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=BotRepository::class)
 */
class Bot
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
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $token;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;


    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_webhook;

    /**
     * @ORM\OneToMany(targetEntity=BotButtons::class, mappedBy="bot" )
     */
    private  $botButtons;

    #[Pure]
    public function __construct()
    {
        $this->botButtons = new ArrayCollection();
    }

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

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


    public function getIsWebhook() : bool
    {
        return $this->is_webhook;
    }

    public function setIsWebhook($is_webhook): self
    {
        $this->is_webhook = $is_webhook;

        return $this;
    }


    public function getBotButtons()
    {
        return $this->botButtons;
    }

    public function addBotButton(BotButtons $botButton): self
    {
        if (!$this->botButtons->contains($botButton)) {
            $this->botButtons[] = $botButton;
            $botButton->setBotId($this);
        }

        return $this;
    }

    public function removeBotButton(BotButtons $botButton): self
    {
        if ($this->botButtons->removeElement($botButton)) {
            // set the owning side to null (unless already changed)
            if ($botButton->getBotId() === $this) {
                $botButton->setBotId(null);
            }
        }

        return $this;
    }

}
