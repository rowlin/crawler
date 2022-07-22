<?php


namespace App\Requests;


use Symfony\Component\Validator\Constraints\NotBlank;

class TemplateRequest
{

    #[NotBlank]
    private $code;

    public function getCode() : string
    {
        return $this->code;
    }

    public function setCode($code): void
    {
        $this->code = $code;
    }


}
