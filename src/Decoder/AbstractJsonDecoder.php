<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\JsonDecoder\Decoder;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wizaplace\JsonDecoder\{
    Exception\JsonDecodeException,
    Exception\JsonDecodeNullException
};

abstract class AbstractJsonDecoder
{
    /** @var bool */
    private $allowNull = true;

    /** @var bool */
    private $associative = false;

    /** @var int */
    private $depth = 512;

    /** @var bool */
    private $bigIntAsString = false;

    /** @var bool */
    private $objectAsArray = false;

    /** @var bool */
    private $validateDecodedData = true;

    /** @return mixed */
    public function decode(string $json, bool $validateDecodedData = null)
    {
        $options = 0;
        if ($this->isBigIntAsString()) {
            $options = $options & JSON_BIGINT_AS_STRING;
        }
        if ($this->isObjectAsArray()) {
            $options = $options & JSON_OBJECT_AS_ARRAY;
        }
        $return = json_decode($json, $this->isAssociative(), $this->getDepth(), $options);

        $lastError = json_last_error();
        if ($lastError !== JSON_ERROR_NONE) {
            throw new JsonDecodeException($json, json_last_error_msg(), $lastError);
        }

        if ($return === null && $this->isAllowNull() === false) {
            throw new JsonDecodeNullException($json);
        }

        if (
            is_array($return)
            && (
                (is_bool($validateDecodedData) && $validateDecodedData)
                || (is_bool($validateDecodedData) === false && $this->isValidateDecodedData())
            )
        ) {
            $optionResolver = new OptionsResolver();
            $this->configureDecodedJson($optionResolver);
            $optionResolver->resolve($return);
        }

        return $return;
    }

    protected function configureDecodedJson(OptionsResolver $optionsResolver): self
    {
        return $this;
    }

    protected function setAllowNull(bool $allowNull): self
    {
        $this->allowNull = $allowNull;

        return $this;
    }

    protected function isAllowNull(): bool
    {
        return $this->allowNull;
    }

    protected function setAssociative(bool $associative): self
    {
        $this->associative = $associative;

        return $this;
    }

    protected function isAssociative(): bool
    {
        return $this->associative;
    }

    protected function setDepth(int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    protected function getDepth(): int
    {
        return $this->depth;
    }

    protected function setBigIntAsString(bool $bigIntAsString): self
    {
        $this->bigIntAsString = $bigIntAsString;

        return $this;
    }

    protected function isBigIntAsString(): bool
    {
        return $this->bigIntAsString;
    }

    protected function setObjectAsArray(bool $objectAsArray): self
    {
        $this->objectAsArray = $objectAsArray;

        return $this;
    }

    protected function isObjectAsArray(): bool
    {
        return $this->objectAsArray;
    }

    protected function setValidateDecodedData(bool $validate): self
    {
        $this->validateDecodedData = $validate;

        return $this;
    }

    protected function isValidateDecodedData(): bool
    {
        return $this->validateDecodedData;
    }
}
