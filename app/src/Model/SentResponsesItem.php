<?php


namespace App\Model;


class SentResponsesItem
{
    private $id;

    private $name;


    private $created_at;

    public function __construct( $id, $name , $created_at)
    {
        $this->id = $id;
        $this->name  = $name;
        $this->created_at = $created_at;
    }


    public function getId()
    {
        return $this->id;
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
