<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Jobs;
use Faker\Factory;

class Job extends Fixture
{
    private $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }

    private function generateJob() {
        $job = new Jobs();
            $job->setName($this->faker->name());
            $job->setUrl($this->faker->url());
            $job->setCode($this->faker->text(1000));
            $job->setActive($this->faker->boolean());
            $job->setMaxCount(20);
            $job->setShowDublicate(false);
            $job->setCron('* * * * *');
        return $job;
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 50; $i++) {
            $manager->persist($this->generateJob());
        }
        $manager->flush();

    }
}
