<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\AttemptToAuthenticate as FortifyAttemptToAuthenticate;

class AttemptToAuthenticate extends FortifyAttemptToAuthenticate
{
    /**
     * Throw a failed authentication validation exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwFailedAuthenticationException($request)
    {
        $this->limiter->increment($request);

        throw ValidationException::withMessages([
            'auth' => [trans('auth.failed')],
        ]);
    }
}
