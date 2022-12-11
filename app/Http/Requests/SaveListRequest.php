<?php

namespace App\Http\Requests;

use App\Models\Item;
use App\Models\Listt;
use App\Models\MeasurementUnit;
use App\Rules\CompatibleMeasurementTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveListRequest extends FormRequest
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

            'items' => 'present|array|max:2500',
            'items.*' => ['required_array_keys:item_id,quantity,measurement_unit_id,trail', new CompatibleMeasurementTypes],
            'items.*.item_id' => ['integer', Rule::exists(Item::class, 'id')->where('user_id', $this->user()->id)],
            'items.*.quantity' => 'numeric|max:999999.99|min:0', // DECIMAL(8,2)
            'items.*.measurement_unit_id' => ['integer', Rule::exists(MeasurementUnit::class, 'id')->where(function($q) {
                return $q->whereIn('id', [1,2,3,4,5])->orWhere('user_id', $this->user()->id);
            })],
            'items.*.trail' => 'string|max:255'
        ];

        if($this->isMethod('POST')) $rules['name'][] = Rule::unique(Listt::class)->where('user_id', $this->user()->id);
        if($this->isMethod('PUT')) $rules['name'][] = Rule::unique(Listt::class)->where('user_id', $this->user()->id)->ignore($this->listt->id);

        return $rules;
    }
}
