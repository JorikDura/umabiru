<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class MissingMethodException extends RuntimeException
{
    private const string ERROR_MESSAGE = "There's no %s method in %s model.";

    /**
     * Throws self exception
     * @param  string  $model
     * @param  string  $method
     * @return never
     */
    public static function create(string $model, string $method): never
    {
        throw new self(
            message: sprintf(self::ERROR_MESSAGE, $method, $model)
        );
    }
}
