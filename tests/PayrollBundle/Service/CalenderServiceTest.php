<?php

namespace tests\PayrollBundle\Service;

use PayrollBundle\Service\CalenderService;

class CalenderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTestDays
     *
     * @param \DateTime $referenceDay
     */
    public function testAllRemainingMonthsAreAvailable(\DateTime $referenceDay)
    {
        $calendarService = new CalenderService();

        $remainingMonths = $calendarService->getRemainingMonths($referenceDay);

        $this->assertEquals(
          13 - $referenceDay->format('m'),
          count($remainingMonths)
        );
        foreach ($remainingMonths as list($year, $month)) {
            $this->assertEquals($referenceDay->format('Y'), $year);
            $this->assertGreaterThanOrEqual($referenceDay->format('m'), $month);
            $this->assertLessThanOrEqual(12, $month);
        }
    }

    /**
     * @return array
     */
    public function getTestDays()
    {
        return [
          [new \DateTime('2000-01-01')],
          [new \DateTime('1985-02-09')],
          [new \DateTime('2010-03-31')],
          [new \DateTime('2012-04-30')],
          [new \DateTime('2017-05-01')],
          [new \DateTime('2017-06-01')],
          [new \DateTime('2017-07-01')],
          [new \DateTime('2017-08-01')],
          [new \DateTime('2017-09-01')],
          [new \DateTime('2017-10-01')],
          [new \DateTime('2017-11-01')],
          [new \DateTime('2017-12-31')],
        ];
    }
}
