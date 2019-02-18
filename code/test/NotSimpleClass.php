<?php
/**
 * Created by PhpStorm.
 * User: Я
 * Date: 16.02.2019
 * Time: 15:33
 */

//namespace test;


class NotSimpleClass extends SimpleClass
implements SomeInterface
{
    /**
     * @var
     */
    public $param3;

    /**
     * @param string $value
     */
    public function setParam3(string $value): void
    {
        $this->param1 = $value;
    }
}
