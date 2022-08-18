<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 30; $i++) {
            $product = new Product();
            $product->setName($faker->word());
            $product->setPrice($faker->numberBetween(10, 1000));
            $product->setDate($faker->dateTimeBetween('-2 years'));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
