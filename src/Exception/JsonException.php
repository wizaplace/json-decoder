<?php
/**
* @author      Wizacha DevTeam <dev@wizacha.com>
* @copyright   Copyright (c) Wizacha
* @license     Proprietary
*/

declare(strict_types=1);

namespace Wizaplace\JsonDecoder\Exception;

class JsonException extends \Exception
{
    /** @var string */
    private $json;

    public function __construct(string $json, string $message, int $code = 0)
    {
        parent::__construct($message, $code);

        $this->json = $json;
    }

    public function getJson(): string
    {
        return $this->json;
    }
}
