<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\JsonDecoder\Test;

use PHPUnit\Framework\TestCase;
use Wizaplace\JsonDecoder\{
    Exception\JsonDecodeException,
    Exception\JsonDecodeNullException
};

class JsonDecoderTest extends TestCase
{
    public function testDefaultConfiguration(): void
    {
        static::assertEquals(
            $this->getExpectedArray(),
            (new JsonDecoder())->decode($this->createJson())
        );
    }

    public function testDepth(): void
    {
        $this->expectException(JsonDecodeException::class);
        static::assertEquals(
            $this->getExpectedArray(),
            (new JsonDecoder(1))->decode($this->createJson())
        );
    }

    public function testSyntaxError(): void
    {
        $this->expectException(JsonDecodeException::class);
        (new JsonDecoder())->decode('{');
    }

    public function testAllowNull(): void
    {
        static::assertEquals(
            null,
            (new JsonDecoder())->decode('null')
        );
    }

    public function testDisallowNull(): void
    {
        $this->expectException(JsonDecodeNullException::class);
        static::assertEquals(
            null,
            (new JsonDecoder(512, false))->decode('null')
        );
    }

    protected function createJson(): string
    {
        return json_encode($this->getArrayToEncode());
    }

    protected function getArrayToEncode(): array
    {
        $object = new \stdClass();
        $object->foo = 'bar';

        return [
            'string' => 'foo',
            'int' => 123456,
            'float' => 123.45,
            'child' => ['foo' => 'bar'],
            'object' => $object
        ];
    }

    protected function getExpectedArray(): array
    {
        $return = $this->getArrayToEncode();
        $return['object'] = ['foo' => 'bar'];

        return $return;
    }
}
