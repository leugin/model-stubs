<?php

namespace Leugin\ModelStubs\Shared\Data\Values;

class ClassPath
{
    private $path;


    private function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function namespace(): string
    {
        $name = $this->getName();
        return str_replace($name, "", $this->getPath());
    }

    public function getName(): string
    {
        $name = explode("/", $this->getPath());
        return $name[count($name) - 1];
    }
}
