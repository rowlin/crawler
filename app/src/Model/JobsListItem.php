<?php


namespace App\Model;


use Symfony\Component\Validator\Constraints\NotBlank;

class JobsListItem
{

    private $id;

    #[NotBlank]
    private $name;

    #[NotBlank]
    private $url;

    private $code;

    private $start_date;

    private $cron;

    private $active;

    private $responses;

    public function __construct($id, $name, $url, $code, $start_date, $cron , $active , $responses)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->code = $code;
        $this->start_date = $start_date;
        $this->cron = $cron;
        $this->active = $active;
        $this->responses = $this->setResponses($responses);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getCron()
    {
        return $this->cron;
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getResponses()
    {
        return $this->responses;
    }

    private function setResponses($resp): array{
        $responses  = [];
        foreach ($resp as $key => $item) {
            $responses[$key]['code'] = $item->getCode();
            $responses[$key]['id'] = $item->getId();
            $responses[$key]['result'] = $item->getResult();
            $responses[$key]['date'] = $item->getDate();
        }
        return  $responses;
    }

}
