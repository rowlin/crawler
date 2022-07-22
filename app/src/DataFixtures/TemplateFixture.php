<?php

namespace App\DataFixtures;

use App\Entity\Templates;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TemplateFixture extends Fixture
{
    private $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }

    private function generate() : Templates{
        $template = new Templates();
        $template->setCode($this->faker->text());
        $template->setName($this->faker->domainName());
        return $template;
    }


    public function load(ObjectManager $manager): void
    {
        for($i =0 ; $i < 5 ; $i++) {
            $manager->persist($this->generate());
        }
        $manager->flush();
    }
}
