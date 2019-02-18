<?php
/**
 * Created by PhpStorm.
 * User: Я
 * Date: 17.02.2019
 * Time: 16:23
 */

//namespace src\model;


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
        $output = [$this->renderHead(), $this->renderConstants(), $this->renderProps(), $this->renderMethods()];
        return implode(PHP_EOL, $output) . '}';
    }

    /**
     * @return string
     */
    private function renderHead(): string
    {
        $extendsSection = implode(', ', $this->extends);
        return "interface $this->name" . PHP_EOL . $extendsSection . PHP_EOL . '{';
    }

    /**
     * @return string
     */
    private function renderConstants()
    {
        $renderedConstants = [];
        foreach ($this->constants as $key => $constant) {
            $renderedConstants[] = "const $key = $constant;";
        }
        return implode(PHP_EOL, $renderedConstants);
    }


    /**
     * @return string
     */
    private function renderProps(): string
    {
        return array_reduce($this->properties,
            function ($acc, \ReflectionProperty $entity) {
                return $acc . GeneratedInterface::renderPrefixes($entity) . '$' . "{$entity->getName()};" . PHP_EOL;
            }, '');
    }

    /**
     * @return string
     */
    private function renderMethods(): string
    {
        return array_reduce($this->methods,
            function ($acc, \ReflectionMethod $entity) {
                $newAcc = $acc . GeneratedInterface::renderPrefixes($entity) . " function {$entity->getName()}(";
                $newAcc .= GeneratedInterface::renderMethodParameters($entity) . ')';
                $newAcc .= $entity->hasReturnType() ? ": {$entity->getReturnType()};" : ';';
                return $newAcc . PHP_EOL;
            }, '');
    }

    /**
     * @param \ReflectionMethod|\ReflectionProperty|\ReflectionClassConstant|null $entity
     * @return string
     */
    static function renderPrefixes($entity): string
    {
        $prefixes = [];
        $prefixes[] = $entity->isProtected() ? 'protected' : 'public';
        $prefixes[] = $entity->isStatic() ? 'static' : '';
        $prefixes[] = $entity instanceof \ReflectionClassConstant ? 'const' : '';
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
                $param = $parameter->getType() . '$' . $parameter->getName();
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
