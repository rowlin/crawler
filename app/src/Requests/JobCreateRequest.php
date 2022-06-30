<?php
namespace App\Requests;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class JobCreateRequest
{

    #[NotBlank]
    private string $name;

    private string $code = "";

    private mixed $active;

    #[NotBlank]
    #[Url]
    private string $url;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getActive(): mixed
    {
        return  $this->active;
    }

    public function setActive(mixed $active): void
    {
        $this->active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
