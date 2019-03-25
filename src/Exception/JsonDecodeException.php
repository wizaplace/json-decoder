<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\JsonDecoder\Exception;

class JsonDecodeException extends JsonException
{
    public function __construct(string $json, string $message, int $code)
    {
        parent::__construct($json, '[' . $this->getErrorName($code) . '] ' . $message, $code);
    }

    protected function getErrorName(int $error): string
    {
        switch ($error) {
            case JSON_ERROR_DEPTH: $return = 'JSON_ERROR_DEPTH'; break;
            case JSON_ERROR_STATE_MISMATCH: $return = 'JSON_ERROR_STATE_MISMATCH'; break;
            case JSON_ERROR_CTRL_CHAR: $return = 'JSON_ERROR_CTRL_CHAR'; break;
            case JSON_ERROR_SYNTAX: $return = 'JSON_ERROR_SYNTAX'; break;
            case JSON_ERROR_UTF8: $return = 'JSON_ERROR_UTF8'; break;
            case JSON_ERROR_RECURSION: $return = 'JSON_ERROR_RECURSION'; break;
            case JSON_ERROR_INF_OR_NAN: $return = 'JSON_ERROR_INF_OR_NAN'; break;
            case JSON_ERROR_UNSUPPORTED_TYPE: $return = 'JSON_ERROR_UNSUPPORTED_TYPE'; break;
            case JSON_ERROR_INVALID_PROPERTY_NAME: $return = 'JSON_ERROR_INVALID_PROPERTY_NAME'; break;
            case JSON_ERROR_UTF16: $return = 'JSON_ERROR_UTF16'; break;
            default: $return = 'UNKNOWN_ERROR';
        }

        return $return;
    }
}
