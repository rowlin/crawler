<?php

namespace App\Tests\Controller;

use App\DataFixtures\TemplateFixture;
use App\Entity\Templates;
use App\Tests\DatabasePrimer;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TemplatesControllerTest extends WebTestCase
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


    private function prepare() : Templates{
        $templates  = new TemplateFixture();
        $templates->load($this->entityManager);
        return  $this->entityManager->getRepository(Templates::class)->findOneBy([]);
    }


    public function testEditTemplate()
    {
        //prepare
        $r = $this->prepare();
        //request
        $this->client->request('PATCH' ,'/api/template/' . $r->getId()  , [] ,[], [] , json_encode(['code' => "test" ])  );

        $this->assertResponseIsSuccessful();
/*
        $pr =  $this->entityManager->getRepository(Templates::class)->findOneBy(['code' => 'test' ]);
        dd($pr);*/

    }

    public function testIndex()
    {
        //prepare
        $this->prepare();
        //request
        $this->client->request('GET' ,'/api/templates'  , [] ,[], [] , json_encode(['code' => "test" ])  );

        $this->assertResponseIsSuccessful();
    }

    public function testDelete()
    {
        //prepare
        $r =  $this->prepare();
        //request
        $this->client->request('DELETE' ,'/api/template/'. $r->getId()  , [] ,[], []   );

        $this->assertResponseIsSuccessful();

        $pr =  $this->entityManager->getRepository(Templates::class)->findOneBy(['id' => $r->getId() ]);
        $this->assertEquals(null , $pr);
    }

    public function testCreate()
    {
        //prepare
        //$r =  $this->prepare();
        //request
        $this->client->request('POST' ,'/api/templates'  ,  ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [],json_encode([ 'code' => 'Test']) );

        $this->assertResponseIsSuccessful();

        $pr =  $this->entityManager->getRepository(Templates::class)->findOneBy(['code' => 'Test']);
        $this->assertEquals(1 , $pr->getId());
    }
}
