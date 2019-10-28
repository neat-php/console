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
    private function createOutput(&$buffer): Output
    {
        $buffer = fopen('php://memory', 'r+');
        $output = new Output($buffer);

        return $output;
    }

    /**
     * Assert buffer contents
     *
     * @param string   $expected
     * @param resource $buffer
     */
    private function assertBuffer($expected, $buffer)
    {
        rewind($buffer);
        $this->assertSame($expected, fread($buffer, 1024));
    }

    /**
     * Test write output
     */
    public function testWrite()
    {
        $output = $this->createOutput($buffer);
        $output->write('abc');
        $output->write('');
        $output->write('def');

        $this->assertBuffer('abcdef', $buffer);
    }

    /**
     * Test line output
     */
    public function testLine()
    {
        $output = $this->createOutput($buffer);
        $output->line('Hello %s!', 'world');
        $output->line();

        $this->assertBuffer('Hello world!' . PHP_EOL . PHP_EOL, $buffer);
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

        $this->assertBuffer('Hello,' . PHP_EOL . 'world!' . PHP_EOL, $buffer);
    }
}
