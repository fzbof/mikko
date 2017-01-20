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
        $salaryPayday = $paydayService->calculateSalaryPayday($year, $month);

        $referenceDay = new \DateTime();
        $referenceDay->setDate($year, $month, 1);

        $this->assertEquals($salaryPayday->format("Y-m-d"), $referenceDay->format("Y-m-t"));
    }

    /**
     * @dataProvider monthEndsInWeekend
     *
     * @param int $year
     * @param int $month
     */
    public function testSalaryPaydayFallsOnLastFridayOfMonthIfItEndsInAWeekend($year, $month)
    {
        $paydayService = new PaydayService();
        $salaryPayday = $paydayService->calculateSalaryPayday($year, $month);

        $referenceDay = new \DateTime();
        $referenceDay->setDate($year, $month, 1);

        $this->assertEquals($salaryPayday->format("w"), 5);
        $this->assertEquals(
          $salaryPayday->format("m"),
          $referenceDay->format("m")
        );
        $this->assertNotEquals(
          $salaryPayday->add(new \DateInterval('P1W'))->format("m"),
          $referenceDay->format("m")
        );
    }

    /**
     * @return array
     */
    public function monthEndsInWeek(){
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
    public function monthEndsInWeekend(){
        return [
          [2017, 4],
          [2017, 9],
        ];
    }
}
