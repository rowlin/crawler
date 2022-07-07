<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Bot extends Fixture
{
    private $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }

    private function generateBot() : \App\Entity\Bot{
        $bot = new \App\Entity\Bot();
        $bot->setName($this->faker->name());
        $bot->setToken($this->faker->text(100));
        $bot->setActive($this->faker->boolean());
        return $bot;
    }


    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $manager->persist($this->generateBot());
        }
        $manager->flush();
    }
}
