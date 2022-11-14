<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeasurementUnit>
 */
class MeasurementUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->text(20),
            'abbreviation' => fake()->unique()->randomLetter() . fake()->unique()->randomLetter(),
            'measurement_type_id' => rand(1,3),
            'convertion' => rand(100,500),
        ];
    }
}
