<?php

namespace App\Service\ExceptionHandler;

class ExceptionMapping
{

    private $code;
    private $hidden;
    private $loggable;

    public function __construct(int $code,  bool $hidden,  bool $loggable)
    {
        $this->code = $code;
        $this->hidden = $hidden;
        $this->loggable = $loggable;
    }

    public static function fromCode(int $code): self
    {
        return new self($code, true, false);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function isLoggable(): bool
    {
        return $this->loggable;
    }
}

