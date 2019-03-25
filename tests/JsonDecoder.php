<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\JsonDecoder\Test;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wizaplace\JsonDecoder\Decoder\AbstractJsonDecoder;

class JsonDecoder extends AbstractJsonDecoder
{
    public function __construct(int $depth = 512, bool $allowNull = true)
    {
        $this
            ->setAssociative(true)
            ->setDepth($depth)
            ->setAllowNull($allowNull);
    }

    protected function configureDecodedJson(OptionsResolver $optionsResolver): parent
    {
        $optionsResolver
            ->setRequired('string')
            ->setAllowedTypes('string', 'string')
            ->setAllowedValues('string', 'foo')

            ->setRequired('int')
            ->setAllowedTypes('int', 'int')
            ->setAllowedValues('int', 123456)

            ->setRequired('float')
            ->setAllowedTypes('float', 'float')
            ->setAllowedValues('float', 123.45)

            ->setRequired('child')
            ->setAllowedTypes('child', 'array')
            ->setAllowedValues('child', [['foo' => 'bar']])

            ->setRequired('object')
            ->setAllowedTypes('object', 'array');

        return $this;
    }
}
