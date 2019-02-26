<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\Test\Decoder;

use PHPUnit\Framework\TestCase;
use Wizaplace\Json\Exception\JsonDecodeException;

class JsonDecoderTest extends TestCase
{
    public function testDefaultConfiguration(): void
    {
        static::assertEquals(
            $this->getExpectedArray(),
            (new JsonDecoder())->decode($this->createJson())
        );
    }

    /** @expectedException \Wizaplace\Json\Exception\JsonDecodeException */
    public function testDepth(): void
    {
        static::assertEquals(
            $this->getExpectedArray(),
            (new JsonDecoder())
                ->setDepth(1)
                ->decode($this->createJson())
        );
    }

    /** @expectedException \Wizaplace\Json\Exception\JsonDecodeException */
    public function testSyntaxError(): void
    {
        (new JsonDecoder())->decode('{');
    }

    public function testAllowNull(): void
    {
        static::assertEquals(
            null,
            (new JsonDecoder())->decode('null')
        );
    }

    /** @expectedException \Wizaplace\Json\Exception\JsonDecodeNullException */
    public function testDisallowNull(): void
    {
        static::assertEquals(
            null,
            (new JsonDecoder())
                ->setAllowNull(false)
                ->decode('null')
        );
        $this->expectException("\Wizaplace\Json\Exception\JsonDecodeNullException");
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