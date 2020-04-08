<?php

namespace Neat\Console\Test;

use Neat\Console\Exception\CommandNotFoundException;
use Neat\Console\Router;
use Neat\Router\Mapper;
use Neat\Router\Splitter;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testResolve()
    {
        $mapper = new Mapper('');
        $mapper->map(['test', 'command'])->setHandler('test-command');
        $router = new Router($mapper, new Splitter(' '));
        $this->assertSame('test-command', $router->resolve('test command'));
    }

    public function testResolveArguments()
    {
        $mapper = new Mapper('');
        $mapper->map(['test', 'command', '*'])->setHandler('test-command');
        $router = new Router($mapper, new Splitter(' '));
        $this->assertSame('test-command', $router->resolve('test command argument1 argument2', $arguments));
        $this->assertSame(['argument1', 'argument2'], $arguments);
    }

    public function testUnResolved()
    {
        $mapper = new Mapper('');
        $router = new Router($mapper, new Splitter(' '));
        $this->expectExceptionObject(new CommandNotFoundException('test command'));
        $router->resolve('test command', $arguments);
    }

    public function testIn()
    {
        $mapper   = new Mapper('');
        $in       = $mapper->map(['test']);
        $splitter = new Splitter(' ');
        $router   = new Router($mapper, $splitter);
        $this->assertEquals(new Router($in, $splitter), $router->in('test'));
    }

    public function testRegister()
    {
        $mapper = new Mapper('');
        $router = new Router($mapper, new Splitter(' '));
        $router->register('test command', 'test-command');
        $expected = new Mapper('');
        $expected->map(['test', 'command'])->setHandler('test-command');
        $this->assertEquals($expected, $mapper);
    }
}
