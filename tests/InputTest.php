<?php

namespace Neat\Service\Test;

use PHPUnit\Framework\TestCase;
use Neat\Console\Input;

class InputTest extends TestCase
{
    /**
     * Create input with preset buffer
     *
     * @param string $buffer
     * @return Input
     */
    protected function createInput($buffer = ''): Input
    {
        $stream = fopen('php://memory', 'r+');
        $input  = new Input($stream);

        fwrite($stream, $buffer);
        rewind($stream);

        return $input;
    }

    /**
     * Test empty input
     */
    public function testEmpty()
    {
        $input = $this->createInput('');

        $this->assertNull($input->character());
        $this->assertNull($input->line());
        $this->assertTrue($input->end());
    }

    /**
     * Test read input
     */
    public function testRead()
    {
        $input = $this->createInput('abcdefghijklmnopqrstuvwxyz');

        $this->assertSame('abc', $input->read(3));
        $this->assertFalse($input->end());
        $this->assertSame('def', $input->read(3));
        $this->assertFalse($input->end());
        $this->assertSame('ghijklmnopqrstuvwxyz', $input->read(1024));
        $this->assertSame('', $input->read(1));
        $this->assertTrue($input->end());
        $this->assertSame('', $input->read(1024));
    }

    /**
     * Test character input
     */
    public function testCharacter()
    {
        $input = $this->createInput("test\n");

        foreach (str_split("test\n") as $character) {
            $this->assertFalse($input->end());
            $this->assertSame($character, $input->character());
        }
        $this->assertFalse($input->end());
        $this->assertNull($input->character());
        $this->assertTrue($input->end());
    }

    /**
     * Test line input
     */
    public function testLine()
    {
        $input = $this->createInput("one\ntwo\nthree\n");

        foreach (['one', 'two', 'three'] as $line) {
            $this->assertFalse($input->end());
            $this->assertSame($line, $input->line());
        }
        $this->assertFalse($input->end());
        $this->assertNull($input->line());
        $this->assertTrue($input->end());
    }

    /**
     * Test lines input
     */
    public function testLines()
    {
        $input = $this->createInput("one\ntwo\nthree\n");

        $this->assertSame(['one', 'two', 'three'], $input->lines());
        $this->assertTrue($input->end());
    }
}
