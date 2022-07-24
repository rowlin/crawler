<?php


namespace App\Jobs;


use App\Entity\JobResponse;
use App\Entity\Jobs;
use App\Entity\SenseBlackList;
use Symfony\Component\HttpClient\HttpClient;

class Runner
{

    public function __construct(){
    }


    public function filterSenseBlackList(mixed $blackList , string $result) : array{
        $result = json_decode($result, true);
        $sense_list =
            array_map(function($item){
                return $item->getSense();
            } , $blackList);

        foreach ($result as $index => $res){
            if(isset($res['text'])) {
                $prev_value = "";
                if(is_array($res['text'])){
                foreach ($res['text'] as $i => $r) {
                    //delete dublicates
                    if ($prev_value === $r) {
                        unset($result[$index]['text'][$i]);
                        //$result[$index]['text'][$i] = "dublicate";
                    }
                    //delete empty values
                    if (empty($r)) {
                        unset($result[$index]['text'][$i]);
                        //$result[$index]['text'][$i] = "deleted";
                    }

                    // delete coincidences
                    if (in_array(trim($r), $sense_list)) {
                        unset($result[$index]['text'][$i]);
                        //$result[$index]['text'][$i] = " delete >..";
                    }

                    if (strlen(trim($r)) < 2) {
                        unset($result[$index]['text'][$i]);
                        //$result[$index]['text'][$i] = " > 2";
                    }
                    //set prev
                    $prev_value = $r;
                }
               }
            }
        }
        return $result;
    }



    public function run( Jobs $current_job) : JobResponse{
        $client =  HttpClient::create();

        $response = $client->request('POST', 'http://puppetter:3000/scrape' , [
            'headers' => [
                'Content-Type' => 'text/html',
            ],
            'body' => $current_job->getCode()]);

        $m_res = $this->filterSenseBlackList( $current_job->getSenseBlackLists()->getValues() , $response->getContent() );
        $job_response =  new JobResponse();
        $job_response->setCode(  $response->getStatusCode())
            ->setJob(  $current_job)
            ->setResult(json_encode($m_res))
            ->setDate(new \DateTime('now'));
        return $job_response;
    }

}
