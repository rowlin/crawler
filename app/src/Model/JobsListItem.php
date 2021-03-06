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

    private $channels;

    private $active;

    private $responses;

    private $senseblacklist;

    private $maxCount;

    private $showDublicate;

    public function __construct($id, $name, $url, $code, $cron , $channels , $active ,$showDublicate , $maxCount ,  $responses ,  $senseblacklist )
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->code = $code;
        $this->cron = $cron;
        $this->channels =  $this->setChannels($channels);
        $this->active = $active;
        $this->maxCount = $maxCount;
        $this->showDublicate = $showDublicate;
        $this->responses = $this->setResponses($responses);
        $this->senseblacklist  = $this->setSenseblacklist($senseblacklist);
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

    public function getActive() :bool
    {
        return $this->active;
    }

    public function getResponses()
    {
        return $this->responses;
    }

    public function getShowDublicate()
    {
        return $this->showDublicate;
    }

    public function setShowDublicate($showDublicate): void
    {
        $this->showDublicate = $showDublicate;
    }

    public function getMaxCount()
    {
        return $this->maxCount;
    }

    public function getChannel()
    {
        return $this->channels;
    }

    public function getSenseblacklist()
    {
        return $this->senseblacklist;
    }

    public function setSenseblacklist($senseblacklist): array
    {
        $result = [];
        foreach ($senseblacklist as $key => $item){
            $result[$key]['id'] = $item->getId();
            $result[$key]['sense'] =  $item->getSense();
        }
        return $result;
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

    private function setChannels($data) : array{
        if($data == null){
            $resp = ['bots' => [ 'id' => null] , 'channels' => [ 'id' => null]];
        }
        else {
            $resp = [
                'id' => $data->getId(),
                'bots' => [
                    'id' => $data->getBots()->getId(),
                    'name' => $data->getBots()->getName(),
                ],
                'channels' =>  [
                    'id' => $data->getChannels()->getId(),
                    'name' => $data->getChannels()->getName()
                ]
                ];
        }

        return $resp;
    }

}
