<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\AlphaNumExtras;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => [
                'required', 
                'string', 
                Rule::unique(User::class),
                'min:2', 
                'max:25', 
                new AlphaNumExtras
                // "regex:/^[a-z0-9ÁÉÍÓÚáéíóúÑñÜü.'_-]+$/i"
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(User::class),
                'max:255',
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'avatar_id' => rand(1,50)
        ]);
    }
}
