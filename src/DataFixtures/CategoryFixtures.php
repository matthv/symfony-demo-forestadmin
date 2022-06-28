<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public CONST CATEGORY_REFERENCE = 'CATEGORY';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $category = new Category();
            $category->setLabel($faker->word());
            $manager->persist($category);

            $this->addReference(self::CATEGORY_REFERENCE . $i, $category);
        }

        $manager->flush();
    }
}
