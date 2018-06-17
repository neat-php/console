<?php

namespace Neat\Service\Test;

use PHPUnit\Framework\TestCase;
use Neat\Console\Output;

class OutputTest extends TestCase
{
    /**
     * Create output with buffer
     *
     * @param resource $buffer
     * @return Output
     */
    public function createOutput(&$buffer): Output
    {
        $buffer = fopen('php://memory', 'r+');
        $output = new Output($buffer);

        return $output;
    }

    /**
     * Test line output
     */
    public function testLine()
    {
        $output = $this->createOutput($buffer);
        $output->line('Hello %s!', 'world');
        $output->line();

        rewind($buffer);
        $this->assertSame('Hello world!' . PHP_EOL . PHP_EOL, fread($buffer, 1024));
    }

    /**
     * Test lines output
     */
    public function testLines()
    {
        $output = $this->createOutput($buffer);
        $output->lines([
            'Hello,',
            'world!',
        ]);

        rewind($buffer);
        $this->assertSame('Hello,' . PHP_EOL . 'world!' . PHP_EOL, fread($buffer, 1024));
    }
}
