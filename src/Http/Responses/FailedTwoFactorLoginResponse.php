<?php

namespace Shopfolio\Http\Responses;

use Illuminate\Validation\ValidationException;
use Shopfolio\Contracts\FailedTwoFactorLoginResponse as FailedTwoFactorLoginResponseContract;

class FailedTwoFactorLoginResponse implements FailedTwoFactorLoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @throws ValidationException
     */
    public function toResponse($request)
    {
        $message = __('The provided two factor authentication code was invalid.');

        if ($request->wantsJson()) {
            throw ValidationException::withMessages(['code' => [$message]]);
        }

        return redirect()->route('shopfolio.login')->withErrors(['email' => $message]);
    }
}
