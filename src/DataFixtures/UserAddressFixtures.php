<?php

namespace App\DataFixtures;

use App\Entity\UserAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserAddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            for ($a = 1; $a <= 2; $a++) {
                $userAddress = new UserAddress();
                $userAddress->setCustomer($this->getReference(UserFixtures::USER_REFERENCE . $i));
                $userAddress->setKeyName($a === 1 ? 'home' : 'work');
                $userAddress->setStreet($faker->address());
                $userAddress->setPostalCode($faker->postcode());
                $userAddress->setCity($faker->city());
                $manager->persist($userAddress);
            }
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
