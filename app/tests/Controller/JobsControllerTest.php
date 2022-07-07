<?php

namespace App\Tests\Controller;

use App\Entity\Jobs;
use App\Repository\JobsRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobsControllerTest extends WebTestCase
{
    private $faker;

    protected function setUp() : void {
        $this->faker = Factory::create();
    }

    public function testIndex(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }


   public function testCreate() : void
   {
       $client = static::createClient();
       $crawler =  $client->request('POST' , '/api/job/create',[]);

       dd($client->getResponse());
       //$this->assertResponseIsSuccessful();

       //$this->assertEquals('200', $crawler->getResponse()->getStatusCode());
    }

    public function testDelete(){

        $client = static::createClient();
        $client->request("DELETE" , '/api/job/',[
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'active' => 1
        ]);

    }


}
