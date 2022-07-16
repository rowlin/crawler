<?php

namespace App\Tests\Controller;

use App\Tests\DatabasePrimer;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobsControllerTest extends WebTestCase
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

    public function testIndex(): void
    {
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testGetJob() : void{
        $this->client->request('GET', '/api/jobs');
        $this->assertResponseIsSuccessful();
    }

   public function testCreateFailed() : void
   {
       $this->client->request('POST' , '/api/job/create', ['HTTP_CONTENT_TYPE' => 'application/json'],
           [], [] ,json_encode([ 'data' => 'data'])  );
       $this->assertResponseStatusCodeSame(400 , '{"message":"Validation failed","details":{"violations":[{"field":"name","message":"This value should not be blank."},{"field":"url","message":"This value should not be blank."}]}}');
    }


    private function createRequest($client , $name = 'test') : void
    {
        $client->request('POST' , '/api/job/create', ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([ 'name' => $name , 'url' => 'http://test.ru' , 'active' => true])  );
    }


    public function testCreateMinimal() :void {
        $this->createRequest($this->client);
        $this->assertResponseIsSuccessful();
    }

    public function testUpdateWithCode(){
        $name  = random_bytes(10);
        dd($name);

        $this->createRequest($this->client , );




        $this->client->request('PATCH' , '/api/job/', ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([ 'name' => 'test' , 'url' => 'http://test.ru' , 'active' => true])  );
        $this->assertResponseIsSuccessful();
    }




/*
    public function testDelete(){

        $client = static::createClient();
        $client->request("DELETE" , '/api/job/',[
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'active' => 1
        ]);

    }*/


}
