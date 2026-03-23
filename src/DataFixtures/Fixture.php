<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;

abstract class Fixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{
    // region constants
    // endregion

    // region public attributes
    // endregion

    // region protected attributes
    // endregion

    // region private attributes
    private ?Generator $faker = null;
    // endregion

    // region magic methods
    // endregion

    // region getters/setters
    // endregion

    // region public methods
    public function getFaker(): Generator
    {
        return $this->faker ??= Factory::create('fr_FR');
    }
    // endregion

    // region protected methods
    // endregion

    // region private methods
    // endregion
}
