<?php


namespace App\Requests;


use Symfony\Component\Validator\Constraints\NotBlank;

class TemplateRequest
{

    #[NotBlank]
    private $code;


    #[NotBlank]
    private $name;

    public function getName() : string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function setCode($code): void
    {
        $this->code = $code;
    }


}
