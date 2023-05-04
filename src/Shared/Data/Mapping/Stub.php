<?php

namespace Leugin\ModelStubs\Shared\Data\Mapping;

use Leugin\ModelStubs\Shared\Data\Values\ClassPath;
use Leugin\ModelStubs\Shared\Data\Values\StubProperty;

class Stub
{
    private $name;

    private $stubPath;

    private $properties = [];
    private $hiddens = [];
    /**
     * @var string|null
     */
    private $namespace;
    /**
     * @var ClassPath|null
     */
    private $extends;

    public function __construct(string $name, string $namespace, ClassPath $extends = null)
    {
        $this->name = $name;
        $this->namespace = $namespace;
        $this->extends = $extends;
    }

    public function addProperty(StubProperty $property): self
    {
        $this->properties[] = $property;

        return $this;
    }

    public function addHidden(StubProperty $property): self
    {
        $this->hiddens[] = $property;

        return $this;
    }

    public function getStubPath(): string
    {
        return $this->stubPath;
    }

    public function setStubPath(string $stubPath): self
    {
        $this->stubPath = $stubPath;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return StubProperty[]
     **/
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getHiddens(): array
    {
        return $this->hiddens;
    }


    public function generate():string
    {
        $using = $this->getUsing();
        $path = $this->getStubPath();
        $content = file_get_contents($path);

          $content = str_replace('{{namespace}}', $this->getNamespace(), $content);
        $content = str_replace('{{filleables}}', $this->getFilleable(), $content);
        $content = str_replace('{{hidden}}', $this->getHidden(), $content);
        $content = str_replace('{{casts}}', $this->getCasts(), $content);
        $content = str_replace('{{use}}', $using, $content);
        $content = str_replace('{{properties}}', $this->getPropertiesContent(), $content);

        if ($this->extends) {
            $content = str_replace('{{model}}', " {$this->getName()} extends {$this->extends->getName()}", $content);
        } else {
            $content = str_replace('{{model}}', $this->getName(), $content);
        }

        return $content;
    }

    private function getPropertiesContent()
    {
        $content = [];
        foreach ($this->getProperties() as $property) {
            $content[] = "\n* @property-read ".implode('|', $property->getTypes()).' '.$property->getName()."\n";
        }

        return implode(", ", $content);
    }
    private function getFilleable()
    {
        $content = [];
        foreach ($this->getProperties() as $property) {
            $content[] = "'{$property->getName()}'";
        }

        return implode(", ", $content);
    }
    private function getHidden()
    {
        return '';
    }
    private function getCasts()
    {
        return '';
    }

    private function getUsing()
    {
        $content = [];
        if ($this->extends) {
            $content[] = "use {$this->extends->getPath()}";
        }

        return implode(";\n", $content);
    }
}
