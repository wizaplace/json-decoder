<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\JsonDecoder\Exception;

class JsonDecodeNullException extends JsonException
{
    public function __construct(string $json)
    {
        parent::__construct($json, 'json_decode() return null but is not allowed by configuration.');
    }
}
