<?php

namespace tests\PayrollBundle\Service;

use PayrollBundle\Service\PaydayService;

class PaydayServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider monthEndsInWeek
     *
     * @param int $year
     * @param int $month
     */
    public function testSalaryPaydayFallsOnLastDayOfMonth($year, $month)
    {
        $paydayService = new PaydayService();
        $salaryPayday  = $paydayService->calculateSalaryPayday($year, $month);

        $referenceDay = new \DateTime();
        $referenceDay->setDate($year, $month, 1);

        $this->assertEquals(
          $salaryPayday->format("Y-m-d"),
          $referenceDay->format("Y-m-t")
        );
    }

    /**
     * @dataProvider monthEndsInWeekend
     *
     * @param int $year
     * @param int $month
     */
    public function testSalaryPaydayFallsOnLastFridayOfMonthIfItEndsInAWeekend(
      $year,
      $month
    ) {
        $paydayService = new PaydayService();
        $salaryPayday  = $paydayService->calculateSalaryPayday($year, $month);

        $referenceDay = new \DateTime();
        $referenceDay->setDate($year, $month, 1);

        $this->assertEquals($salaryPayday->format("w"), 5, "on a friday");
        $this->assertEquals(
          $salaryPayday->format("m"),
          $referenceDay->format("m"),
          "same month"
        );
        $this->assertNotEquals(
          $salaryPayday->add(new \DateInterval('P1W'))->format("m"),
          $referenceDay->format("m"),
          "last week of the month"
        );
    }

    /**
     * @dataProvider nextFifteenthIsInWeek
     *
     * @param int $year
     * @param int $month
     */
    public function testBonusPaydayFallsOnNextFifteenth($year, $month)
    {
        $paydayService = new PaydayService();
        $bonusPayday   = $paydayService->calculateBonusPayday($year, $month);

        $referenceDay = new \DateTime();
        $referenceDay->setDate($year, $month + 1, 15);

        $this->assertEquals(
          $bonusPayday->format("Y-m-d"),
          $referenceDay->format("Y-m-d")
        );
    }

    /**
     * @dataProvider nextFifteenthIsInWeekend
     *
     * @param int $year
     * @param int $month
     */
    public function testBonusPaydayFallsOnFirstWednesdayAfterFifteenth(
      $year,
      $month
    ) {
        $paydayService = new PaydayService();
        $bonusPayday   = $paydayService->calculateBonusPayday($year, $month);

        $referenceDay = new \DateTime();
        $referenceDay->setDate($year, $month + 1, 15);

        $this->assertEquals($bonusPayday->format("w"), 3, "on a wednesday");
        $this->assertEquals(
          $bonusPayday->format("m"),
          $month + 1,
          "of next month"
        );
        $this->assertLessThan(
          $bonusPayday,
          $referenceDay,
          "after the fifteenth"
        );
        $this->assertGreaterThan(
          $bonusPayday,
          $referenceDay->add(new \DateInterval('P1W')),
          "in the week after the fifteenth"
        );
    }

    /**
     * @return array
     */
    public function monthEndsInWeek()
    {
        return [
          [2017, 1],
          [2017, 2],
          [2017, 3],
          [2017, 5],
          [2017, 6],
          [2017, 7],
          [2017, 8],
        ];
    }

    /**
     * @return array
     */
    public function monthEndsInWeekend()
    {
        return [
          [2017, 4],
          [2017, 9],
        ];
    }

    /**
     * @return array
     */
    public function nextFifteenthIsInWeek()
    {
        return [
          [2017, 1],
          [2017, 2],
          [2017, 4],
          [2017, 5],
          [2017, 7],
        ];
    }

    /**
     * @return array
     */
    public function nextFifteenthIsInWeekend()
    {
        return [
          [2017, 3],
          [2017, 6],
        ];
    }
}
