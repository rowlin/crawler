<?php


namespace App\Service;


use App\Entity\SentResponse;
use App\Exception\NotFoundException;
use App\Model\SentResponsesItem;
use App\Repository\SentResponseRepository;

class SentResponsesService
{


    public function __construct( private SentResponseRepository $sentResponseRepository)
    {
    }

    public function getSentResponses(int $id) : array {
        $current_job =  $this->sentResponseRepository->getCurrentJob($id);
        if(!$current_job)
            throw new NotFoundException('Job not found');
        return array_map( function($data){
            return new SentResponsesItem(
                $data->getName(),
                $data->getCreatedAt()
            );}  , $current_job->getSentResponses()->getValues() );
    }

    public function deleteSentResponses(int $id){
        $current_response =  $this->sentResponseRepository->findOneBy(['id' => $id]);
        if(!$current_response)
            throw  new NotFoundException('That sent response not found');
        $this->sentResponseRepository->remove($current_response  , true);

        return ['message' => "Response was deleted"];
    }

}
