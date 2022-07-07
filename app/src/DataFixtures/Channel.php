<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Channel extends Fixture
{

    private $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }

    private function generateChannel() : \App\Entity\Channel{
        $channel = new \App\Entity\Channel();
        $channel->setName($this->faker->name());
        $channel->setChatId($this->faker->text(100));
        return $channel;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $manager->persist($this->generateChannel());
        }
        $manager->flush();

    }
}
