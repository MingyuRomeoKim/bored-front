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

        return redirect()
            ->back()
            ->withErrors($errors, 'login')
            ->withInput();
    }
}
