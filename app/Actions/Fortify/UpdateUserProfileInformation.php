<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\AlphaNumExtras;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'username' => [
                'required', 
                'string', 
                Rule::unique(User::class)->ignore($user->id),
                'min:2', 
                'max:25', 
                new AlphaNumExtras
                // "regex:/^[a-z0-9ÁÉÍÓÚáéíóúÑñÜü.'_-]+$/i"
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(User::class)->ignore($user->id),
                'max:255',
            ],
            'avatar_id' => 'required|integer|exists:avatars,id'
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'username' => $input['username'],
                'email' => $input['email'],
                'avatar_id' => $input['avatar_id'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'username' => $input['username'],
            'email' => $input['email'],
            'avatar_id' => $input['avatar_id'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
