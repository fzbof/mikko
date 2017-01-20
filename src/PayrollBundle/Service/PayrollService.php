<?php

namespace PayrollBundle\Service;

/**
 * Class PayrollService
 *
 * @package PayrollBundle\Service
 */
class PayrollService
{
    /**
     * @var string
     */
    private $dateOutputFormat = "Y-m-d";

    /**
     * @var CalendarServiceInterface
     */
    private $calendarService;

    /**
     * @var PaydayServiceInterface
     */
    private $paydayService;

    public function __construct(
      CalendarServiceInterface $calendarService,
      PaydayServiceInterface $paydayService
    ) {
        $this->calendarService = $calendarService;
        $this->paydayService   = $paydayService;
    }

    /**
     * @param \DateTime $startDate    Day for which to generate the payroll
     *                                calendar
     * @param string    $filename     Location to write the payroll calendar to
     */
    public function createPayrollCalendar(\DateTime $startDate, $filename)
    {
        $handle = fopen($filename, 'w');

        $remainingMonths = $this->calendarService->getRemainingMonths(
          $startDate
        );

        foreach ($remainingMonths as list($year, $month)) {
            $this->writePaydayLine($handle, $year, $month);
        }

        fclose($handle);
    }

    /**
     * @param resource $handle
     * @param int      $year
     * @param int      $month
     */
    private function writePaydayLine($handle, $year, $month)
    {
        $salaryDay = $this->paydayService->calculateSalaryPayday(
          $year,
          $month
        );

        $bonusDay = $this->paydayService->calculateBonusPayday(
          $year,
          $month
        );

        fputcsv(
          $handle,
          [
            $month,
            $salaryDay->format($this->dateOutputFormat),
            $bonusDay->format($this->dateOutputFormat),
          ]
        );
    }
}