<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\MeasurementType;
use App\Models\MeasurementUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequiredSeeder extends Seeder
{
    private $avatars = [
        'aubergine.png',
        'beer.png',
        'birthday-cake.png',
        'biscuit.png',
        'bread.png',
        'breakfast.png',
        'brochettes.png',
        'burger.png',
        'carrot.png',
        'cheese.png',
        'chicken-1.png',
        'chicken.png',
        'chocolate-1.png',
        'chocolate-2.png',
        'chocolate.png',
        'cocktail.png',
        'coffee.png',
        'coke.png',
        'covering.png',
        'croissant.png',
        'cup.png',
        'cupcake.png',
        'donut.png',
        'egg.png',
        'fish.png',
        'fries.png',
        'honey.png',
        'hot-dog.png',
        'icecream.png',
        'jam.png',
        'jelly.png',
        'juice.png',
        'ketchup.png',
        'lemon.png',
        'lettuce.png',
        'loaf.png',
        'milk.png',
        'noodles.png',
        'pepper.png',
        'pickles.png',
        'pie.png',
        'pizza.png',
        'rice.png',
        'sausage.png',
        'spaguetti.png',
        'steak.png',
        'tea.png',
        'water-glass.png',
        'watermelon.png',
        'wine.png',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->avatars as $avatar) {
            Avatar::create(['name' => $avatar]);
        }

        MeasurementType::create(['name' => 'Peso']); // 1
        MeasurementType::create(['name' => 'Volumen']); // 2
        MeasurementType::create(['name' => 'Unidad']); // 3

        MeasurementUnit::create([
            'name' => 'Gramo',
            'abbreviation' => 'g',
            'measurement_type_id' => 1,
            'convertion' => 1,
        ]);
        MeasurementUnit::create([
            'name' => 'Kilogramo',
            'abbreviation' => 'kg',
            'measurement_type_id' => 1,
            'convertion' => 1000,
        ]);
        MeasurementUnit::create([
            'name' => 'Mililitro',
            'abbreviation' => 'mL',
            'measurement_type_id' => 2,
            'convertion' => 1,
        ]);
        MeasurementUnit::create([
            'name' => 'Litro',
            'abbreviation' => 'L',
            'measurement_type_id' => 2,
            'convertion' => 1000,
        ]);
        MeasurementUnit::create([
            'name' => 'Unidad',
            'abbreviation' => '',
            'measurement_type_id' => 3,
            'convertion' => NULL,
        ]);
    }
}
