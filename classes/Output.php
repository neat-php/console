<?php

namespace Neat\Console;

class Output
{
    /**
     * @var resource
     */
    protected $stream;

    /**
     * Output constructor
     *
     * @param resource|mixed $stream
     */
    public function __construct($stream = STDOUT)
    {
        $this->stream = $stream;
    }

    /**
     * Write output line
     *
     * @param string $line
     * @param array  ...$parameters
     */
    public function line($line = '', ...$parameters)
    {
        fprintf($this->stream, $line . PHP_EOL, ...$parameters);
    }

    /**
     * Write output lines
     *
     * @param string[] $lines
     */
    public function lines(array $lines = [])
    {
        foreach ($lines as $line) {
            fwrite($this->stream, $line . PHP_EOL);
        }
    }
}
