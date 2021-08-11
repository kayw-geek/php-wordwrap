<?php


class WrapTest extends \PHPUnit\Framework\TestCase
{
    public function testWrap()
    {
        $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
        $wrap = new \KaywGeek\WordWrap();
        $formatText = $wrap->text($text)->width(20)->wrap();
        $str = <<<STR
Lorem ipsum dolor
sit amet,
consectetur
adipiscing elit, sed
do eiusmod tempor
incididunt ut labore
et dolore magna
aliqua.
STR;
        $this->assertEquals($formatText,$str);
    }

    public function testWrapBreakFalse()
    {
        $text = "https://github.com/kayw-geek/php-wordwrap";
        $wrap = new \KaywGeek\WordWrap();
        $formatText = $wrap->text($text)->width(28)->break(false)->wrap();
        $str = <<<STR
https://github.com/kayw-geek/php-wordwrap
STR;
        $this->assertEquals($formatText,$str);
    }
    public function testWrapBreakTrue()
    {
        $text = "https://github.com/kayw-geek/php-wordwrap";
        $wrap = new \KaywGeek\WordWrap();
        $formatText = $wrap->text($text)->width(28)->break()->wrap();
        $str = <<<STR
https://github.com/kayw-geek
/php-wordwrap
STR;
        $this->assertEquals($formatText,$str);
    }
    public function testWrapLf()
    {
        $text = "Of course,the first example appears to be the nicest one (or perhaps the fourth),but you may find that being able to use empty expressions in for loops comes in handy in many occasions.";
        $wrap = new \KaywGeek\WordWrap();
        $formatText = $wrap->text($text)->lfEnable()->wrap();
        $str = <<<STR
Of course,
the first example appears to be the nicest one (or perhaps the fourth),
but you may find that being able to use empty expressions in for loops comes in handy in many occasions.
STR;
        $this->assertEquals($formatText,$str);
    }

    public function testFormat()
    {
        $text = "Of course,the first example appears to be the nicest one (or perhaps the fourth),but you may find that being able to use empty expressions in for loops comes in handy in many occasions.";
        $wrap = new \KaywGeek\WordWrap();
        $formatText = $wrap->text($text)->lfEnable()->responseFormat(\KaywGeek\WordWrap::FORMAT_JSON)->wrap();
        $str = <<<STR
["Of course,","the first example appears to be the nicest one (or perhaps the fourth),","but you may find that being able to use empty expressions in for loops comes in handy in many occasions."]
STR;
        $this->assertEquals($formatText,$str);
    }

    public function testFormatArray()
    {
        $text = "Of course,the first example appears to be the nicest one (or perhaps the fourth),but you may find that being able to use empty expressions in for loops comes in handy in many occasions.";
        $wrap = new \KaywGeek\WordWrap();
        $formatText = $wrap->text($text)->lfEnable()->responseFormat(\KaywGeek\WordWrap::FORMAT_ARRAY)->wrap();
        $this->assertIsArray($formatText);
    }
}