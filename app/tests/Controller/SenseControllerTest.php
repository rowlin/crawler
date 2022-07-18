<?php

namespace App\Tests\Controller;

use App\DataFixtures\Job;
use App\DataFixtures\Sense;
use App\Entity\Jobs;
use App\Entity\SenseBlackList;
use App\Tests\DatabasePrimer;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SenseControllerTest extends WebTestCase
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


    private function preparationJob() : Jobs{
        $job = new Job();
        $job->load($this->entityManager);
        $current_job  = $this->entityManager->getRepository(Jobs::class)->findOneBy([]);
        return  $current_job;
    }

    private function preparationSense(Jobs $current_job): SenseBlackList{
        $sense =  new Sense();
        $sense->load($this->entityManager , $current_job);
        $current_sense = $this->entityManager->getRepository(SenseBlackList::class)->findOneBy([]);
        return $current_sense;
    }



    public function testAdd() : void
    {
        //preparation
        $current_job = $this->preparationJob();
        //action
        $this->client->request('PUT' , '/api/sense/'. $current_job->getId(), ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([ 'sense' => 'new_data' ])  );

        $this->assertResponseIsSuccessful();
    $updated_sense  = $this->entityManager->getRepository(SenseBlackList::class)->findOneBy([]);
        $this->assertEquals('new_data' , $updated_sense->getSense());
    }

    public function testUpdate() : void
    {
        $current_job = $this->preparationJob();
        $o_sense  = $this->preparationSense($current_job);
        $old_sense  = $o_sense->getSense();
        //action
        $this->client->request('POST' , '/api/sense/'. $o_sense->getId() , ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([ 'sense' => 'new_data' ])  );

        $this->assertResponseIsSuccessful();
     /** OOps: fix that
        $updated_sense  = $this->entityManager->getRepository(SenseBlackList::class)->findAll();

        dd($updated_sense);
        $this->assertEquals('new_data' , $updated_sense);
      */
    }

    public function testDelete() : void
    {
        $current_job = $this->preparationJob();
        $o_sense  = $this->preparationSense($current_job);
        $sense_id  = $o_sense->getId();
        $this->client->request('DELETE' , '/api/sense/'. $o_sense->getId() , ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], []   );
        $this->assertResponseIsSuccessful();
/*        $updated_sense  = $this->entityManager->getRepository(SenseBlackList::class)->find($sense_id);
        dd($updated_sense);*/

    }



}
