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
            ->setCode('D15')
            ->setType(CouponTypeEnum::Fixed)
            ->setValue('15'));

        $manager->persist((new Coupon())
            ->setCode('P10')
            ->setType(CouponTypeEnum::Percent)
            ->setValue('10'));


        $manager->flush();
    }
}
