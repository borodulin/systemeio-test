<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new Tax())
            ->setCountryCode('DE')
            ->setValue(19));
        $manager->persist((new Tax())
            ->setCountryCode('IT')
            ->setValue(22));
        $manager->persist((new Tax())
            ->setCountryCode('GR')
            ->setValue(24));
        $manager->persist((new Tax())
            ->setCountryCode('FR')
            ->setValue(26));

        $manager->flush();
    }
}
