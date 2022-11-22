<?php

/* Used in FortifyServiceProvider > boot > Fortify::authenticateThrough */

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
                // to show the "credentials not match our records" 
                // on the form instead of just on email (because maybe 
                // the email didn't failed but the password, and that 
                // could be confusing for the user)
        ]);
    }
}
