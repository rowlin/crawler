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

/*    public function testCreate():void
    {
        $client = self::createClient();
        $client->request("POST" , '/api/job/create',[
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'active' => 1
        ]);
        $response  = $client->getResponse()->getContent();
        dd($response);
        $this->assertEquals('200', $client->getResponse()->getStatusCode());


    }*/

    public function testDelete(){

        $client = self::createClient();
        $client->request("DELETE" , '/api/job/',[
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'active' => 1
        ]);



    }


}
