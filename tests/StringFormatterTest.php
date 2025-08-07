<?php

namespace StringFormatter\Tests;

use PHPUnit\Framework\TestCase;
use StringFormatter\StringFormatter;

class StringFormatterTest extends TestCase
{
    public function testPadLeft()
    {
        $this->assertEquals('000123', StringFormatter::padLeft('123', 6, '0'));
    }

    public function testPadRight()
    {
        $this->assertEquals('123000', StringFormatter::padRight('123', 6, '0'));
    }

    public function testReplace()
    {
        $this->assertEquals('A-B-C', StringFormatter::replace('A_B_C', '_', '-'));
        $this->assertEquals('A-B-C', StringFormatter::replace('A B C', 'space', '-'));
    }

    public function testRemove()
    {
        $this->assertEquals('ABC', StringFormatter::remove('A_B_C', '_'));
        $this->assertEquals('ABC', StringFormatter::remove('A B C', 'space'));
    }

    public function testInsertAfterFirst()
    {
        $this->assertEquals('K 123', StringFormatter::insertAfterFirst('K123', ' ', 1));
        $this->assertEquals('K000123', StringFormatter::insertAfterFirst('K123', '0', 3));
    }

    public function testPadAfterFirst()
    {
        $this->assertEquals('K00123', StringFormatter::padAfterFirst('K123', 5, '0'));
    }

    public function testApply()
    {
        $this->assertEquals(
            'K 00000563793',
            StringFormatter::apply('K563793', 'insertAfterFirst: :1;padAfterFirst:11:0')
        );
    }
}