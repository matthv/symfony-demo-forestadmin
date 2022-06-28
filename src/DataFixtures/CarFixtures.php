<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public CONST CAR_REFERENCE = 'CAR';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            $car = new Car();
            $car->setReference($faker->word());
            $car->setModel($faker->word());
            $car->setBrand($faker->word());
            $car->setYear($faker->numberBetween(2015, 2022));
            $car->setNbSeats($faker->numberBetween(4, 8));
            $car->setIsManual($faker->boolean(33));
            $car->setOptions([]);

            $car->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE . $faker->numberBetween(1, 10)));

            for ($n = 1; $n <= 3; $n++) {
                $car->addCheck($this->getReference(CheckFixtures::CHECK_REFERENCE . $n));
            }

            $manager->persist($car);

            $this->addReference(self::CAR_REFERENCE . $i, $car);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            CheckFixtures::class,
        ];
    }


}
