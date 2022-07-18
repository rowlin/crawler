<?php

namespace App\DataFixtures;

use App\Entity\Jobs;
use App\Entity\SenseBlackList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Sense extends Fixture
{

    private $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }

    public function generate(?Jobs $job) : SenseBlackList{
       $sense =  new SenseBlackList();
       $sense->setSense($this->faker->domainName());
       $sense->setJobs($job);
       return $sense;
    }


    public function load(ObjectManager $manager , ?Jobs $job = null): void
    {
        $manager->flush();
        $manager->persist($this->generate($job));
        $manager->flush();
    }
}
