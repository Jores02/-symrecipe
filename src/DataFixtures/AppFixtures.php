<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Faker\Generator;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create(locale: 'fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $ingredients = [];

        for ($i = 1; $i <= 50; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setPrice(mt_rand(1, 199));
            $manager->persist($ingredient);
            $ingredients[] = $ingredient;
        }

        for ($i = 1; $i <= 25; $i++) {
            $recipe = new Recipe();
            $recipe->setName($this->faker->sentence(3))
                ->setDescription($this->faker->paragraph())
                ->setIsFavorite((bool) rand(0, 1))
                ->setTime(mt_rand(5, 180))
                ->setNbPersons(mt_rand(1, 10))
                ->setDifficulty(mt_rand(1, 5))
                ->setPrice(mt_rand(0, 1000));

            $randomIngredients = $this->faker->randomElements($ingredients, rand(2, 5));
            foreach ($randomIngredients as $ingredient) {
                $recipe->addIngredient($ingredient);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
