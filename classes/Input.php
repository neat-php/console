<?php

namespace Neat\Console;

class Input
{
    /**
     * @var resource
     */
    protected $stream;

    /**
     * Input constructor
     *
     * @param resource $stream
     */
    public function __construct($stream = null)
    {
        $this->stream = $stream ?? STDIN;
    }

    /**
     * Get input character
     *
     * @return string|null
     */
    public function character()
    {
        $character = fgetc($this->stream);

        return $character === false ? null : $character;
    }

    /**
     * Get input line
     *
     * @return string|null
     */
    public function line()
    {
        $line = fgets($this->stream);

        return $line === false ? null : rtrim($line, "\r\n");
    }

    /**
     * Get multiple input lines
     *
     * @return array
     */
    public function lines()
    {
        $lines = [];
        while (!feof($this->stream)) {
            $line = fgets($this->stream);
            if ($line !== false) {
                $lines[] = rtrim($line, "\r\n");
            }
        }

        return $lines;
    }

    /**
     * Reached the end?
     *
     * @return bool
     */
    public function end()
    {
        return feof($this->stream);
    }
}
