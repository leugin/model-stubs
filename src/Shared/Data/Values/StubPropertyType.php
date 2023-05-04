<?php

namespace Leugin\ModelStubs\Shared\Data\Values;

class StubPropertyType
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function string(): self
    {
        return new self('string');
    }

    public static function int(): self
    {
        return new self('int');
    }

    public function nullable(): self
    {
        return new self('null');
    }

    public static function bool(): self
    {
        return new self('bool');
    }

    public function __toString()
    {
        return $this->getName();
    }
}