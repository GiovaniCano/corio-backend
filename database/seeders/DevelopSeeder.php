<?php

namespace Database\Seeders;

use App\Models\Day;
use App\Models\DaySection;
use App\Models\Dish;
use App\Models\Item;
use App\Models\Itemable;
use App\Models\Listt;
use App\Models\MeasurementUnit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(2)
            ->has(Day::factory(3)->has(DaySection::factory(4)))
            ->has(Dish::factory(10))
            ->has(Listt::factory(4), 'lists')
            ->has(MeasurementUnit::factory(2))
            ->has(Item::factory(30))
            ->create();

        $users = User::with('dishes', 'lists', 'days.daySections', 'items')->get();

        $users->each(function($user) {
            foreach($user->dishes as $dish) {
                $dish->items()->syncWithPivotValues($user->items->random(rand(4,10)), [
                    'quantity' => fake()->randomFloat(2,1,600),
                    'measurement_unit_id' => rand(1,5),
                ]);
            }

            foreach($user->lists as $list) {
                $list->items()->syncWithPivotValues($user->items->random(rand(4,10)), [
                    'quantity' => fake()->randomFloat(2,1,600),
                    'measurement_unit_id' => rand(1,5),
                ]);
                // trail
            }

            foreach($user->days as $day) {
                foreach($day->daySections as $daySection) {
                    $daySection->dishes()->sync($user->dishes->random(rand(1,4)));
                    $daySection->items()->syncWithPivotValues($user->items->random(rand(1,4)), [
                        'quantity' => fake()->randomFloat(2,1,600),
                        'measurement_unit_id' => rand(1,5),
                    ]);
                }
            }
        });

        $itemables = Itemable::query()->where('itemable_type', Listt::class)->get();
        $itemables->each(function($itemable){ 
            $itemable->trail()->create(['trail' => fake()->text(81)]);
        });
    }
}
