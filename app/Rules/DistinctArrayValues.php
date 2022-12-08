<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Validator;

class DistinctArrayValues implements InvokableRule
{
    function __construct(string $key = '')
    {
        $this->key = $key;
    }
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
        $validationKey = $this->key ? "array.*.{$this->key}" : 'array.*';

        $validation = Validator::make(['array' => $value], [
            $validationKey => 'distinct'
        ]);

        if($validation->fails()) $fail(__('validation.distinct'));
    }
}
