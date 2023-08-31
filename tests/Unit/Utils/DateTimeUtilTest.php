<?php

namespace Tests\Unit\Utils;

use App\Utils\DateTimeUtil;
use PHPUnit\Framework\TestCase;

class DateTimeUtilTest extends TestCase
{
    public function test_date_should_be_converted_to_end_of_date(): void
    {
        // Setup
        $date1 = '2023/01/01';
        $date2 = '2023/12/01';
        $endTimeOfDay = '23:59:59.999999';

        // Asserts
        $this->assertEquals($date1 . ' ' . $endTimeOfDay, DateTimeUtil::dateToEndOfDate($date1));
        $this->assertEquals($date2 . ' ' . $endTimeOfDay, DateTimeUtil::dateToEndOfDate($date2));
    }

    public function test_it_should_be_returned_first_date_of_month(): void
    {
        // Asserts
        $this->assertEquals('2023/01/01', DateTimeUtil::getFirstDateOfMonth(1, 2023));
        $this->assertEquals('2023/04/01', DateTimeUtil::getFirstDateOfMonth(4, 2023));
    }

    public function test_it_should_be_returned_last_date_of_month(): void
    {
        // Asserts
        $this->assertEquals('2023/01/31', DateTimeUtil::getLastDateOfMonth(1, 2023));
        $this->assertEquals('2023/04/30', DateTimeUtil::getLastDateOfMonth(4, 2023));
        $this->assertEquals('2023/02/28', DateTimeUtil::getLastDateOfMonth(2, 2023));
        $this->assertEquals('1900/02/28', DateTimeUtil::getLastDateOfMonth(2, 1900));
        $this->assertEquals('2000/02/29', DateTimeUtil::getLastDateOfMonth(2, 2000));
    }

    public function test_it_should_be_returned_last_day_of_month(): void
    {
        // Asserts
        $this->assertEquals(31, DateTimeUtil::getLastDayOfMonth(1, 2023));
        $this->assertEquals(30, DateTimeUtil::getLastDayOfMonth(4, 2023));
        $this->assertEquals(28, DateTimeUtil::getLastDayOfMonth(2, 2023));
        $this->assertEquals(28, DateTimeUtil::getLastDayOfMonth(2, 1900));
        $this->assertEquals(29, DateTimeUtil::getLastDayOfMonth(2, 2000));
    }
}
