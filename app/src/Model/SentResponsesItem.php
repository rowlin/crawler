<?php


namespace App\Model;


class SentResponsesItem
{
    private $name;


    private $created_at;


    public function __construct( $name , $created_at)
    {
        $this->name  = $name;
        $this->created_at = $created_at;
    }


    public function getName() : string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }


}
