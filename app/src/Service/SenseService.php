<?php


namespace App\Service;


use App\Entity\SenseBlackList;
use App\Exception\NotFoundException;
use App\Repository\SenseBlackListRepository;
use App\Requests\SenseRequest;

class SenseService
{
    public function __construct(private SenseBlackListRepository $senseBlackListRepository)
    {
    }


    public function add(SenseRequest $request,  int $id  ): array{
        $current_job  =  $this->senseBlackListRepository->getCurrentJob($id);
        $sense = new SenseBlackList();
        $sense->setSense($request->getSense());
        $current_job->addSenseBlackList($sense);
        $this->senseBlackListRepository->add($sense, true);
        return  ['message' => "Sense was added"];
    }


    public function update(int $id , SenseRequest $data) : array{
        $s  = $this->senseBlackListRepository->findOneBy([ 'id' => $id]);

        if(!$s){
                throw new NotFoundException();
        }
        else {
            $s->setSense($data->getSense());
            $this->senseBlackListRepository->add($s , true);
        }
        return [ 'message' => 'Sense updated' ];
    }

    public function delete(int $id) : array{
        $s  = $this->senseBlackListRepository->find($id);
        if(!$s){
            throw new NotFoundException();
        }
        else {
            $this->senseBlackListRepository->remove($s , true);
        }
        return  ['message' => 'Sense deleted'];
    }

}
