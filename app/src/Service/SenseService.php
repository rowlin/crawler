<?php


namespace App\Service;


use App\Exception\NotFoundException;
use App\Repository\SenseBlackListRepository;
use App\Requests\SenseRequest;

class SenseService
{
    public function __construct(private SenseBlackListRepository $senseBlackListRepository)
    {
    }

    public function update(int $id , SenseRequest $data) : array{
        $s  = $this->senseBlackListRepository->findOneBy(['id' , $id]);
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
        $s  = $this->senseBlackListRepository->findOneBy(['id' , $id]);
        if(!$s){
            throw new NotFoundException();
        }
        else {
            $this->senseBlackListRepository->remove($s);
        }
        return  ['message' => 'Sense deleted'];
    }

}
