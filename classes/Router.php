<?php

namespace Neat\Console;

use Neat\Console\Exception\CommandNotFoundException;
use Neat\Router\Mapper;
use Neat\Router\Splitter;

class Router
{
    /** @var Splitter */
    private $splitter;

    /** @var Mapper */
    private $mapper;

    /**
     * Router constructor.
     * @param Mapper   $mapper
     * @param Splitter $splitter
     */
    public function __construct(Mapper $mapper, Splitter $splitter)
    {
        $this->mapper   = $mapper;
        $this->splitter = $splitter;
    }

    /**
     * @param string $command
     * @return static
     */
    public function in(string $command): self
    {
        return new static($this->mapper->map($this->splitter->split($command)), $this->splitter);
    }

    /**
     * @param string   $command
     * @param callable $handler
     * @return Router
     */
    public function register(string $command, $handler)
    {
        $this->mapper->map($this->splitter->split($command))->setHandler($handler);

        return $this;
    }

    /**
     * @param array      $argv
     * @param array|null $arguments
     * @return callable
     */
    public function resolve(array $argv, array &$arguments = null)
    {
        /** @var Mapper $match */
        foreach ($this->mapper->match($argv, $arguments) as $match) {
            return $match->getHandler();
        }

        throw new CommandNotFoundException(implode(' ', $argv));
    }
}
