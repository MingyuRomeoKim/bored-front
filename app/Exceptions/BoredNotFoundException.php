<?php

namespace App\Exceptions;

use Exception;

class BoredNotFoundException extends Exception
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

        if ($errors['code'] == BoredErrorCode::$COMMON_NOT_FOUND['code']) {

        }

        return redirect()
            ->back()
            ->withErrors($errors, 'errors')
            ->withInput();
    }
}
