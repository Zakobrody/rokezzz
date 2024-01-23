<?php

namespace App\DataFixtures;

use App\Factory\ApplyFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ApplyFactory::createMany(40);

        $manager->flush();
    }
}
