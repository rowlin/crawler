<?php

namespace App\Tests\Controller;

use App\DataFixtures\Bot;
use App\Tests\DatabasePrimer;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BotControllerTest extends WebTestCase
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


    public function testGetAll() : void{
        $bots =  new Bot();
        $bots->load($this->entityManager);
        $this->client->request('GET' ,'/api/bot' );
        $this->assertResponseIsSuccessful();
    }

    public function testCreate(){



    }

    public function testDelete(){



    }


    public function testUpdate()
    {

    }
}
