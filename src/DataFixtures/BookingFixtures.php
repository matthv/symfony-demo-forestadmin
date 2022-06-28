<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            $booking = new Booking();
            $booking->setStartDate($faker->dateTimeBetween('-1 month', '-2 days'));
            $booking->setEndDate($faker->dateTimeBetween('now'));

            $booking->setCustomer($this->getReference(UserFixtures::USER_REFERENCE . $faker->numberBetween(1, 50)));
            $booking->setCar($this->getReference(CarFixtures::CAR_REFERENCE . $faker->numberBetween(1, 50)));

            $manager->persist($booking);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CarFixtures::class,
        ];
    }
}
