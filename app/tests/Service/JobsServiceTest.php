<?php

namespace App\Tests\Service;

use App\Entity\Jobs;
use App\Model\JobsListItem;
use App\Model\JobsListResponse;
use App\Repository\JobResponseRepository;
use App\Repository\JobsRepository;
use App\Service\JobsService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
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
                ->setChannel(null)
                ->setCron('* * * * *')
                ->setChannel(null)
            ]);

        $respRepository = $this->createMock(JobResponseRepository::class);
        $respEventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $jobs = new JobsService($repository , $respRepository , $respEventDispatcher);
        $expected = new JobsListResponse([new JobsListItem(55, 'test', 'https://test.dev', '<pre>test</pre>',
             "* * * * *" , null , true , []  , new ArrayCollection())]);

        $this->assertEquals( $expected ,  $jobs->getJobs() );
    }

/*    public function testGetJobsWithSense(){
        $repository = $this->createMock(JobsRepository::class);
        $mockBotChannel = $this->createMock(BotChannelRepository::class);

        $repository->expects($this->once())
            ->method('getAll')
            ->with(true)
            ->willReturn([(new Jobs())
                ->setId(55)
                ->setName('test')
                ->setUrl('https://test.dev')
                ->setActive(true)
                ->setCode('<pre>test</pre>')
                ->setChannel(null)
                ->setCron('* * * * *')
            ]);

        $respRepository = $this->createMock(JobResponseRepository::class);
        $respEventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $jobs = new JobsService($repository , $respRepository , $respEventDispatcher);
        $expected = new JobsListResponse([new JobsListItem(55, 'test', 'https://test.dev', '<pre>test</pre>',
            "* * * * *" , null , true , []  , new ArrayCollection())]);

        $this->assertEquals( $expected ,  $jobs->getJobs() );

    }*/



}
