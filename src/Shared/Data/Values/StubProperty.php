<?php

namespace Leugin\ModelStubs\Shared\Data\Values;

class StubProperty
{
    private $types;
    private $name;

    public function __construct(string $name, StubPropertyType ...$types)
    {
        $this->name = $name;
        $this->types = $types;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTypes(): array
    {
        return $this->types;
    }
}
