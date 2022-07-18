<?php

namespace App\Tests\Controller;

use App\DataFixtures\Bot;
use App\DataFixtures\Channel;
use App\DataFixtures\Job;
use App\Entity\Jobs;
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


    private function createRequest( $name = 'test') : void
    {
        $this->client->request('POST' , '/api/job/create', ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([ 'name' => $name , 'url' => 'http://test.ru' , 'active' => true])  );
    }


    public function testCreateMinimal() :void {
        $this->createRequest();
        $this->assertResponseIsSuccessful();
    }

    public function testUpdateWithExtra() : void{
        //preparation
        $name  = $this->faker->domainName();
        $bot =  new Bot();
        $bot->load($this->entityManager);
        $channel = new Channel();
        $channel->load($this->entityManager);
        $this->createRequest($name);

        $current_job =  $this->entityManager->getRepository(Jobs::class)->findOneBy(['name' => $name]);
        $current_bot =  $this->entityManager->getRepository(\App\Entity\Bot::class)->findOneBy([]);
        $current_channel =  $this->entityManager->getRepository(\App\Entity\Bot::class)->findOneBy([]);

        $id = $current_job->getId();

        //request
        $this->client->request('PATCH' , "/api/job/$id", ['HTTP_CONTENT_TYPE' => 'application/json'],
            [], [] ,json_encode([
                'name' => $name ,
                'url' => $this->faker->url() ,
                "active" => $this->faker->boolean() ,
                "channel"=>  [
                        "bots" =>  [
                            "id"=> $current_bot->getId()
                        ],
                        "channels"=>  [
                            "id" => $current_channel->getId()
                        ]
                ],
                "code" => "(async () => {\n  const browser = await puppeteer.launch(\n{\nargs: ['--no-sandbox', '--disable-setuid-sandbox'],\nignoreHTTPSErrors: true\n}\n);\nconst page = await browser.newPage();\nawait page.setViewport({\nwidth: 1240,\nheight: 800,\ndeviceScaleFactor: 1,\n});\n\nawait page.goto('https://cv.ee/ru/search?limit=20&offset=0&categories%5B0%5D=INFORMATION_TECHNOLOGY&towns%5B0%5D=312&keywords%5B0%5D=php&fuzzy=true&suitableForRefugees=false&isHourlySalary=false&isQuickApply=false&languages%5B0%5D=ru');\nawait page.waitForSelector('.vacancies-list');\n\nlet data = await page.eval('.vacancies-list__item', (links ) => {\nvar res = [];\nvar i = 0;\nlinks.forEach( (l, i )=> {\nreturn res[i++] =  {\n'url':  l.querySelector('a').href,\n'text':  [].map.call(l.querySelectorAll('span') , function(obj){\nreturn  obj.innerText;\n})\n}\n}\n)\nreturn res;\n});\nreturn data;\nawait browser.close();\n})();",
                "cron" => "*/15 * * * *",
                "senseblacklist" => [],
            ]
                ));

        //assert
        $this->assertResponseIsSuccessful();
    }


    public function testDelete() : void{
        //preparation
        $job = new Job();
        $job->load($this->entityManager);

        $current_job = $this->entityManager->getRepository(Jobs::class)->findOneBy([]);
        $current_job_id  = $current_job->getId();
        $this->client->request("DELETE" , '/api/job/' . $current_job_id);

        //assert
        $this->assertResponseIsSuccessful();

        $current_job_res = $this->entityManager->getRepository(Jobs::class)->findOneBy(['id' =>  $current_job_id]);
        $this->assertEquals(null , $current_job_res);
    }


}
