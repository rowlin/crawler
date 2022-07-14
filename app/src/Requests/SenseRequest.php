<?php


namespace App\Requests;


use Symfony\Component\Validator\Constraints\NotBlank;

class SenseRequest
{

    #[NotBlank]
    private string $sense;

    public function getSense(): string
    {
        return $this->sense;
    }

    public function setSense(string $sense): void
    {
        $this->sense = $sense;
    }

}
