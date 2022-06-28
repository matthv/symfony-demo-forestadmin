<?php

namespace App\DataFixtures;

use App\Entity\Check;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CheckFixtures extends Fixture
{
    public CONST CHECK_REFERENCE = 'CHECK';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 150; $i++) {
            $check = new Check();
            $check->setGarageName($faker->company());
            $check->setDate(new \DateTime());
            $check->setCreatedAt(new \DateTimeImmutable());
            $check->setUpdatedAt(new \DateTime());
            $manager->persist($check);

            $this->addReference(self::CHECK_REFERENCE . $i, $check);
        }


        $manager->flush();
    }
}
