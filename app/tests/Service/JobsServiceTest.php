<?php

namespace App\Tests\Service;

use App\Entity\Jobs;
use App\Model\JobsListItem;
use App\Model\JobsListResponse;
use App\Repository\JobResponseRepository;
use App\Repository\JobsRepository;
use App\Service\JobsService;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;

class JobsServiceTest extends TestCase
{

    public function testGetJobs()
    {
        $repository = $this->createMock(JobsRepository::class);

        $repository->expects($this->once())
            ->method('getAll')
            ->with(true)
            ->willReturn([(new Jobs())
                ->setId(55)
                ->setName('test')
                ->setUrl('https://test.dev')
                ->setActive(true)
                ->setCode('<pre>test</pre>')
                ->setChannel(1)
                ->setCron('* * * * *')
                ->setNotify(true)
            ]);


        $respRepository = $this->createMock(JobResponseRepository::class);

        $jobs = new JobsService($repository , $respRepository);
        $expected = new JobsListResponse([new JobsListItem(55, 'test', 'https://test.dev', '<pre>test</pre>',
             "* * * * *" , true , 1 , true , [])]);

        $this->assertEquals( $expected ,  $jobs->getJobs() );

    }
}
