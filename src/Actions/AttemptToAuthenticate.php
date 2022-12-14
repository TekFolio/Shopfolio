<?php

namespace Shopfolio\Actions;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Shopfolio\Services\TwoFactor\LoginRateLimiter;
use Shopfolio;

class AttemptToAuthenticate
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * The login rate limiter instance.
     *
     * @var \Shopfolio\\Services\TwoFactor\LoginRateLimiter
     */
    protected $limiter;

    /**
     * Create a new controller instance.
     */
    public function __construct(StatefulGuard $guard, LoginRateLimiter $limiter)
    {
        $this->guard = $guard;
        $this->limiter = $limiter;
    }

    /**
     * Handle the incoming request.
     *
     * @throws ValidationException
     */
    public function handle(Request $request, $next)
    {
        if ($this->guard->attempt(
            $request->only(Shopfolio::username(), 'password'),
            $request->filled('remember')
        )
        ) {
            return $next($request);
        }

        $this->throwFailedAuthenticationException($request);
    }

    /**
     * Throw a failed authentication validation exception.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwFailedAuthenticationException(Request $request)
    {
        $this->limiter->increment($request);

        throw ValidationException::withMessages([Shopfolio::username() => [trans('auth.failed')]]);
    }
}
