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

    private $cron;

    private $notity;

    private $channel;

    private $active;

    private $responses;

    public function __construct($id, $name, $url, $code, $cron ,$notify , $channel , $active , $responses)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->code = $code;
        $this->cron = $cron;
        $this->notify = $notify;
        $this->channel = $channel;
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

    public function getActive()
    {
        return $this->active;
    }

    public function getResponses()
    {
        return $this->responses;
    }


    public function getNotity() : bool
    {
        return $this->notity;
    }

    public function getChannel()
    {
        return $this->channel;
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
