<?php

namespace App\Tests\Controller;

use App\DataFixtures\Job;
use App\DataFixtures\SentResponses;
use App\Entity\Jobs;
use App\Tests\DatabasePrimer;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SentResponseControllerTest extends WebTestCase
{

    private $faker;
    private $entityManager;
    protected $client;


    protected function setUp() : void {
        $this->client = static::createClient();
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->faker = Factory::create();
    }

    private function prepareJobs() : Jobs{
        $bot =  new Job();
        $bot->load($this->entityManager);
        return $this->entityManager->getRepository(Jobs::class)->findOneBy([]);
    }

    public function testGetResponses()
    {
        //assume
        $current_job = $this->prepareJobs();
        $sent_responses = new SentResponses();
        $sent_responses->load($this->entityManager , $current_job , $this->faker->url());

        //request
        $this->client->request('GET' , '/api/responses/'. $current_job->getId(), ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([])  );

        //assert
        $this->assertResponseIsSuccessful();
    }

    public function testDeleteResponse()
    {
        //assume
        $current_job = $this->prepareJobs();
        $sent_responses = new SentResponses();
        $sent_responses->load($this->entityManager , $current_job , $this->faker->url());
        $sr = $this->entityManager->getRepository(\App\Entity\SentResponse::class)->findOneBy([]);
        //request
        $this->client->request('DELETE' , '/api/responses/'. $sr->getId(), ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([])  );
        //assert
        $this->assertResponseIsSuccessful();

        $result = $this->entityManager->getRepository(\App\Entity\SentResponse::class)->findOneBy(['id' => $sr->getId()]);
        //check has databases
        $this->assertEquals(null ,$result);
    }
}
