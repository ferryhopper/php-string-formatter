<?php

namespace StringFormatter\Tests;

use PHPUnit\Framework\TestCase;
use StringFormatter\StringFormatter;

class StringFormatterTest extends TestCase
{
     public function testPadLeft()
    {
        $result = StringFormatter::padLeft('123', 5, '0');
        $this->assertEquals('00123', $result);
    }

    public function testPadRight()
    {
        $result = StringFormatter::padRight('123', 5, '0');
        $this->assertEquals('12300', $result);
    }

    public function testReplace()
    {
        $result = StringFormatter::replace('A_B_C', '_', '-');
        $this->assertEquals('A-B-C', $result);

        $result = StringFormatter::replace('A B C', 'space', '-');
        $this->assertEquals('A-B-C', $result);
    }

    public function testRemove()
    {
        $result = StringFormatter::remove('A_B_C', '_');
        $this->assertEquals('ABC', $result);

        $result = StringFormatter::remove('A B C', 'space');
        $this->assertEquals('ABC', $result);
    }

    public function testapplySingleStep()
    {
        $result = StringFormatter::apply('123', 'padLeft:5:0');
        $this->assertEquals('00123', $result);
    }

    public function testapplyMultipleSteps()
    {
        $result = StringFormatter::apply('K123_45', 'replace:_:space;padLeft:10:0');
        $this->assertEquals('000K123 45', $result);
    }

    public function testapplyWithUnknownFunction()
    {
        $result = StringFormatter::apply('123', 'nonexistent:arg');
        $this->assertEquals('123', $result); // fallback: return original input
    }


    public function testapplyHandlesWhitespace()
    {
        $result = StringFormatter::apply('123', ' padLeft : 5 : 0 ');
        $this->assertEquals('00123', $result);
    }

    public function testPadAfterFirstPadsCorrectly()
    {
        $result = StringFormatter::padAfterFirst('K123', 5, '0');
        $this->assertEquals('K00123', $result);
    }

    public function testPadAfterFirstPadsNothingIfExactLength()
    {
        $result = StringFormatter::padAfterFirst('K12345', 5, '0');
        $this->assertEquals('K12345', $result);
    }

    public function testPadAfterFirstTruncatesNothingIfAlreadyLonger()
    {
        $result = StringFormatter::padAfterFirst('K1234567', 5, '0');
        $this->assertEquals('K1234567', $result);
    }

    public function testPadAfterFirstWorksWithSpaces()
    {
        $result = StringFormatter::padAfterFirst('K123', 6, ' ');
        $this->assertEquals('K   123', $result);
    }

    public function testPadAfterFirstOnEmptyString()
    {
        $result = StringFormatter::padAfterFirst('', 5, '0');
        $this->assertEquals('', $result);
    }

    public function testPadAfterFirstOnOneCharString()
    {
        $result = StringFormatter::padAfterFirst('K', 3, '0');
        $this->assertEquals('K000', $result);
    }
}