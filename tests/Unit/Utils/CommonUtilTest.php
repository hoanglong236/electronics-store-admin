<?php

namespace Tests\Unit\Utils;

use App\Utils\CommonUtil;
use PHPUnit\Framework\TestCase;

class CommonUtilTest extends TestCase
{
    public function test_keyword_should_be_escaped(): void
    {
        // Asserts
        $this->assertEquals("foo", CommonUtil::escapeKeyword("foo"));
        $this->assertEquals("\%", CommonUtil::escapeKeyword("%"));
        $this->assertEquals("foo!@\%\%", CommonUtil::escapeKeyword("foo!@%%"));
        $this->assertEquals("\_", CommonUtil::escapeKeyword("_"));
        $this->assertEquals("\_foo\_\%", CommonUtil::escapeKeyword("_foo_%"));
    }

    public function test_map_should_be_converted_to_params_string(): void
    {
        // Setup
        $map = [
            'ab1' => 'AB1',
            'keyword' => 'Test keyword',
            'empty' => '',
            'null' => null,
        ];
        $expectStr = 'ab1=AB1&keyword=Test keyword&empty=&null=';

        // Asserts
        $this->assertEquals($expectStr, CommonUtil::convertMapToParamsString($map));
    }

    public function test_empty_map_should_be_converted_to_empty_params_string(): void
    {
        // Asserts
        $this->assertTrue(CommonUtil::convertMapToParamsString([]) === '');
    }
}
