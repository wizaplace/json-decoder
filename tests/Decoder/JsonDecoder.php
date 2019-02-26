<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\Test\Decoder;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wizaplace\Json\Decoder\AbstractJsonDecoder;

class JsonDecoder extends AbstractJsonDecoder
{
    public function __construct()
    {
        $this->setAssociative(true);
    }

    public function setAllowNull(bool $allow): parent
    {
        return parent::setAllowNull($allow);
    }

    public function setDepth(int $depth): parent
    {
        return parent::setDepth($depth);
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