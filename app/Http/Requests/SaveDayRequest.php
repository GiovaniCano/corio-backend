<?php

namespace App\Http\Requests;

use App\Models\Day;
use App\Models\Dish;
use App\Models\Item;
use App\Models\MeasurementUnit;
use App\Rules\CompatibleMeasurementTypes;
use App\Rules\DistinctArrayValues;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveDayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:25'], //unique below

            'sections' => 'present|array|max:100',
            'sections.*' => 'required_array_keys:name,dishes,items',
            'sections.*.name' => ['required', 'string', 'max:25'],

            'sections.*.dishes' => ['array', 'max:100', new DistinctArrayValues],
            'sections.*.dishes.*' => ['integer', Rule::exists(Dish::class, 'id')->where('user_id', $this->user()->id)],
            
            'sections.*.items' => ['array', 'max:100', new DistinctArrayValues('item_id')],
            'sections.*.items.*' => ['required_array_keys:item_id,quantity,measurement_unit_id', new CompatibleMeasurementTypes],
            'sections.*.items.*.item_id' => ['integer', Rule::exists(Item::class, 'id')->where('user_id', $this->user()->id)],
            'sections.*.items.*.quantity' => 'numeric|max:999999.99|min:0', // DECIMAL(8,2)
            'sections.*.items.*.measurement_unit_id' => ['integer', Rule::exists(MeasurementUnit::class, 'id')->where(function($q) {
                return $q->whereIn('id', [1,2,3,4,5])->orWhere('user_id', $this->user()->id);
            })]
        ];

        if($this->isMethod('POST')) $rules['name'][] = Rule::unique(Day::class)->where('user_id', $this->user()->id);
        if($this->isMethod('PUT')) $rules['name'][] = Rule::unique(Day::class)->where('user_id', $this->user()->id)->ignore($this->day->id);

        return $rules;
    }
}
