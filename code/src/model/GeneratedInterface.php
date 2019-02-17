<?php
/**
 * Created by PhpStorm.
 * User: Я
 * Date: 17.02.2019
 * Time: 16:23
 */

namespace src\model;


class GeneratedInterface
{
    private $name;

    private $extends;

    private $properties;

    private $methods;

    private $constants;

    /**
     * GeneratedInterface constructor.
     * @param string $name
     * @param array $extends
     * @param array $constants
     * @param \ReflectionProperty[]|array $properties
     * @param \ReflectionMethod[]|array $methods
     */
    public function __construct(string $name, $extends = [], $constants = [], $properties = [], $methods = [])
    {
        $this->name = $name;
        $this->extends = $extends;
        $this->properties = $properties;
        $this->methods = $methods;
        $this->constants = $constants;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->renderHead() . $this->renderConstants() . $this->renderProps() . $this->renderMethods();
    }

    /**
     * @return string
     */
    private function renderHead(): string
    {
        $extendsSection = implode(', ', $this->extends);
        $head = "interface $this->name" . PHP_EOL . $extendsSection . PHP_EOL . '{';
        return $head;
    }

    /**
     * @return string
     */
    private function renderConstants()
    {
        $renderedConstants = [];
        foreach ($this->constants as $key => $constant) {
            $interfaceConstants[] = "const $key = $constant;";
        }
        return implode(PHP_EOL, $renderedConstants);
    }


    /**
     * @return string
     */
    private function renderProps(): string
    {
        return array_reduce($this->properties,
            function (\ReflectionProperty $entity, $acc) {
                return $acc . GeneratedInterface::renderPrefixes($entity) . " {$entity->getName()};" . PHP_EOL;
            }, '');
    }

    /**
     * @return string
     */
    private function renderMethods(): string
    {
        return array_reduce($this->methods,
            function (\ReflectionMethod $entity, $acc) {
                $newAcc = $acc . GeneratedInterface::renderPrefixes($entity) . " function {$entity->getName()}(";
                $newAcc .= GeneratedInterface::renderMethodParameters($entity) . ')';
                $newAcc .= $entity->hasReturnType() ? ": {$entity->getReturnType()}" : '';
                return $newAcc;
            }, '');
    }

    /**
     * @param \ReflectionMethod|\ReflectionProperty|\ReflectionClassConstant|null $entity
     * @return string
     */
    static function renderPrefixes(?\ReflectionProperty $entity): string
    {
        $prefixes = [];
        $prefixes[] = $entity->isProtected() ? 'protected' : 'public';
        $prefixes[] = $entity->isStatic() ? 'static' : '';
        $prefixes[] = $entity instanceof \ReflectionClassConstant ? 'const' : '';
        $prefixes[] = $entity instanceof \ReflectionMethod ? 'function' : '';
        $prefixes[] = $entity->getName();
        return implode(' ', $prefixes);
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    static function renderMethodParameters(\ReflectionMethod $method)
    {
        $params = array_map(
            function (\ReflectionParameter $parameter) {
                $param = "{$parameter->getType()} {$parameter->getName()}";
                try {
                    $param .= " = {$parameter->getDefaultValue()}";
                } catch (\Throwable $e) {
                }
                return $param;
            },
            $method->getParameters()
        );
        return implode(',', $params);
    }
}