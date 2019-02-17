<?php
/**
 * Created by PhpStorm.
 * User: Я
 * Date: 16.02.2019
 * Time: 15:33
 */

namespace test;


class SimpleClass
{
    public const PI = 3.14159;

    protected const E = 1;
    /**
     * @var String|null
     */
    public $param1;
    /**
     * @var
     */
    private $param2;

    public function getParam1(): string
    {
        return (string)$this->param1;
    }

    /**
     * @param string $value
     */
    public function setParam1(string $value)
    {
        $this->param1 = $value;
    }
}