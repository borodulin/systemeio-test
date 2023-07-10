<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Enum\CouponTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new Coupon())
            ->setCode('F10')
            ->setType(CouponTypeEnum::Fixed)
            ->setValue('10'));

        $manager->persist((new Coupon())
            ->setCode('P06')
            ->setType(CouponTypeEnum::Percent)
            ->setValue('6'));


        $manager->flush();
    }
}
