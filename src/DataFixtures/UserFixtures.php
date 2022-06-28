<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public CONST USER_REFERENCE = 'USER';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            $user = new User();
            $user->setName($faker->name());
            $user->setEmail($faker->email());
            $user->setRememberToken($faker->boolean(75));
            $manager->persist($user);

            $this->addReference(self::USER_REFERENCE . $i, $user);
        }

        $manager->flush();
    }
}
