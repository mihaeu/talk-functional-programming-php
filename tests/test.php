<?php

require '/home/mike/workspace/dephpend/vendor/autoload.php';

function eq(callable $fn, $context, $message = '') : void
{
    if (!is_object($context)) {
        throw new InvalidArgumentException("$context has to be an object.");
    }
    $test = \Closure::bind($fn, $context, $context);
    \PHPUnit\Framework\TestCase::assertTrue($test(), $message);
}

function neq(callable $fn, $context, $message = '') : void
{
     if (!is_object($context)) {
        throw new InvalidArgumentException("$context has to be an object.");
    }
    $test = \Closure::bind($fn, $context, $context);
    \PHPUnit\Framework\TestCase::assertFalse($test(), $message);
}

class Test2
{
    private function secret(int $x) : int
    {
        return $x + 1;
    }
}

class SomeTest extends PHPUnit\Framework\TestCase
{
    public function testIncorrect() : void
    {
       eq(function () {
            return 1 === $this->secret(1);
       }, new Test2, 'Argument was not changed');
    }

    public function testCorrect() : void
    {
        eq(function () {
            return 2 === $this->secret(1);
        }, new Test2);
    }
}

