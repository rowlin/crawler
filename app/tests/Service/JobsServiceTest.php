<?php

namespace App\Tests\Service;

use App\Entity\JobResponse;
use App\Entity\Jobs;
use App\Model\JobsListItem;
use App\Model\JobsListResponse;
use App\Repository\JobsRepository;
use App\Service\JobsService;
use Doctrine\Common\Collections\Criteria;
use phpDocumentor\Reflection\Types\This;
use PHPUnit\Framework\TestCase;

class JobsServiceTest extends TestCase
{

/*    public function testGetJobs()
    {
        $repository = $this->createMock(JobsRepository::class);

        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['id' => Criteria::DESC])
            ->willReturn([(new Jobs())->setId(55)->setName('test')
                ->setUrl('https://test.dev')
                ->setActive(true)
                ->setCode('<pre>test</pre>')
                ->setStartDate(null)
                ->setCron('* * * * *')
            ]);

        $jobs = new JobsService($repository);
        $expected = new JobsListResponse([new JobsListItem(55, 'test', 'https://test.dev', '<pre>test</pre>',
           null , "* * * * *" , true , [])]);

        $this->assertEquals( $expected ,  $jobs->getJobs() );
    }*/
}
