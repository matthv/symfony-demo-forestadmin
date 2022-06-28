<?php

namespace App\DataFixtures;

use App\Entity\DriverLicence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DriverLicenceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            $driverLicence = new DriverLicence();
            $driverLicence->setReference($faker->word());
            $driverLicence->setOwner($this->getReference(UserFixtures::USER_REFERENCE . $i));
            $manager->persist($driverLicence);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
