<?php

namespace App\Exceptions;

use Exception;

class BoredTokenException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render()
    {
        $errors = [
            'code' => $this->getCode(),
            'message' => $this->getMessage()
        ];

        if ($errors['code'] == BoredErrorCode::$JWT_INVALID['code']) {
            cookie()->queue(cookie('userData', null, -1));
        }

        if ($errors['code'] == BoredErrorCode::$COMMON_NOT_LOGIN['code']) {
            return redirect()->back()->withErrors($errors, 'login');
        }

        return redirect()
            ->back()
            ->withErrors($errors, 'errors')
            ->withInput();
    }
}
