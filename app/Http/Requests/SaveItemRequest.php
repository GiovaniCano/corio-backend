<?php

namespace App\Http\Requests;

use App\Models\Item;
use App\Models\MeasurementType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveItemRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:25', Rule::unique(Item::class)->where('user_id', $this->user()->id)],
            'measurement_type_id' => 'required|integer|exists:'.MeasurementType::class.',id'
        ];
    }
}
