<?php
/**
 * Created by PhpStorm.
 * User: Я
 * Date: 17.02.2019
 * Time: 15:22
 */

//namespace src\service;
//
//use src\model\GeneratedInterface;
//TODO Use composer
include 'FileManagerService.php';
include "/src/model/GeneratedInterface.php";

class InterfaceGeneratorService
{
    /**
     * @param string $path
     * @return GeneratedInterface
     */
    public function generateFromFile(string $path)
    {
        $reflector = FileManagerService::readClassFromFile($path);
        return $this->generateForClass($reflector);
    }

    /**
     * @param \ReflectionClass $class
     * @return GeneratedInterface
     */
    private function generateForClass(\ReflectionClass $class)
    {
        return new GeneratedInterface(
            $this->generateNameForInterface($class->getName()),
            $class->getInterfaceNames(),
            $class->getConstants(),
            $class->getProperties(),
            $class->getMethods()
        );
    }

    /**
     * @param $className
     * @return string
     */
    private function generateNameForInterface($className) {
        return $className . 'Interface';
    }
}