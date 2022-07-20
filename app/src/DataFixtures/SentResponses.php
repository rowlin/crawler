<?php

namespace App\DataFixtures;

use App\Entity\Jobs;
use App\Entity\SentResponse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SentResponses extends Fixture
{

    private $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }


    public function generate($job , $name){
        $sent_responses =  new SentResponse();
        $sent_responses->setJobId($job);
        $sent_responses->setName($name);
        $sent_responses->setCreatedAt(new \DateTime('now'));
        return $sent_responses;
    }


    public function load(ObjectManager $manager , Jobs $jobs = null , string $name  = null ): void
    {
        if($name === null){
            $name = $this->faker->url();
        }

        for ($i = 0; $i < 5; $i++) {
            $manager->persist($this->generate($jobs, $name));
            $name = $this->faker->url();
        }
        $manager->flush();
    }

}
