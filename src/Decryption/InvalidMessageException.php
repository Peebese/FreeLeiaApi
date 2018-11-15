<?php
/**
 * Created by PhpStorm.
 * User: philipbrown
 * Date: 13/11/2018
 * Time: 08:17
 */

namespace PhilipBrown\ThisIsBud\Decryption;

use Throwable;

class InvalidMessageException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponseBody(string $responseBody): InvalidMessageException
    {
        return new static('Expected JSON with "cell" and "block" fields, but got: ' . var_export($responseBody, true));
    }

}