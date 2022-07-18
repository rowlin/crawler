<?php


namespace App\Jobs;


use App\Entity\JobResponse;
use App\Entity\Jobs;
use Symfony\Component\HttpClient\HttpClient;

class Runner
{

    public function __construct(){
    }


    public function run( Jobs $current_job) : JobResponse{
        $client =  HttpClient::create();

        $response = $client->request('POST', 'http://puppetter:3000/scrape' , [
            'headers' => [
                'Content-Type' => 'text/html',
            ],
            'body' => $current_job->getCode()]);

        //TODO: удалить если запросов больше N


        $job_response =  new JobResponse();
        $job_response->setCode(  $response->getStatusCode())
            ->setJob(  $current_job)
            ->setResult($response->getContent())
            ->setDate(new \DateTime('@'.strtotime('now')));
        return $job_response;
    }

}
