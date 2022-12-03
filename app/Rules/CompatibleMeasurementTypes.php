<?php

namespace App\Rules;

use App\Models\Item;
use App\Models\MeasurementUnit;
use Illuminate\Contracts\Validation\InvokableRule;

class CompatibleMeasurementTypes implements InvokableRule
{

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $item_type_id = Item::without('measurementType')->findOrFail($value['item_id'])->measurement_type_id;
        $unit_type_id = MeasurementUnit::without('measurementType')->findOrFail($value['measurement_unit_id'])->measurement_type_id;

        if($item_type_id != $unit_type_id) {
            $fail(__('validation.in'));
        }
    }
}
