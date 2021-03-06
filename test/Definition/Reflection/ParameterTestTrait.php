<?php

/**
 * @see       https://github.com/laminas/laminas-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-di/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace LaminasTest\Di\Definition\Reflection;

use LaminasTest\Di\TestAsset;
use ReflectionClass;

trait ParameterTestTrait
{
    private function reflectAsset($methodName, $parameterIndex = 0)
    {
        $all = (new ReflectionClass(TestAsset\Parameters::class))->getMethod($methodName)->getParameters();
        return $all[$parameterIndex];
    }

    private function buildReflectionArgsFromClass($classname)
    {
        $class = new ReflectionClass($classname);
        $invocationArgs = [];

        /** @var \ReflectionMethod $method */
        foreach ($class->getMethods() as $method) {
            $params = $method->getParameters();
            $typename = substr($method->name, 0, -4);
            $invocationArgs[$typename] = [ $params[0], $typename ];
        }

        return $invocationArgs;
    }

    public function provideBuiltinTypehintedReflections()
    {
        return $this->buildReflectionArgsFromClass(TestAsset\BuiltinTypehintParameters::class);
    }

    public function provideTypehintedParameterReflections()
    {
        return [
            'required' => [$this->reflectAsset('typehintRequired'), TestAsset\A::class],
            'optional' => [$this->reflectAsset('typehintOptional'), TestAsset\A::class],
        ];
    }

    public function provideTypelessParameterReflections()
    {
        return [
            'required' => [$this->reflectAsset('typelessRequired')],
            'optional' => [$this->reflectAsset('typelessOptional')],
        ];
    }
}
