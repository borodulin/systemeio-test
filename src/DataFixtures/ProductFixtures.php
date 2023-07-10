<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new Product())
            ->setName('Iphone')
            ->setPrice('100.00'));
        $manager->persist((new Product())
            ->setName('Наушники')
            ->setPrice('20.00'));
        $manager->persist((new Product())
            ->setName('Чехол')
            ->setPrice('10.00'));

        $manager->flush();
    }
}
