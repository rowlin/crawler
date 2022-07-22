<?php


namespace App\Service;


use App\Entity\Templates;
use App\Exception\NotFoundException;
use App\Repository\TemplatesRepository;
use App\Requests\TemplateRequest;

class TemplateService
{
    public function __construct(private TemplatesRepository $templatesRepository){
    }


    public function getAll() : array{
        return $this->templatesRepository->findAll();
    }

    public function create(TemplateRequest $data): array{
        $template =  new Templates();
        $template->setCode($data->getCode());
        $this->templatesRepository->add( $template ,true);
        return [ 'message' => 'Template created'];

    }

    public function delete( int $id) :array{
        $template = $this->templatesRepository->findOneBy(['id' => $id ]);
        if(!$template)
            throw new NotFoundException('That template not found');
         $this->templatesRepository->remove($template , true);
        return ['message' => 'Template deleted'];
    }

    public function edit(int $id, TemplateRequest $data ) : array{
        $template = $this->templatesRepository->findOneBy(['id' => $id ]);
        if(!$template)
            throw new NotFoundException('That template not found');
        $template->setCode($data->getCode());
        $this->templatesRepository->add($template , true);
        return  ['message' => 'Template updated'];
    }

}
