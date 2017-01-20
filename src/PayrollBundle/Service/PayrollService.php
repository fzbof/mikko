<?php

namespace PayrollBundle\Service;

class PayrollService
{
    /**
     * @var string
     */
    private $csvFormat = "Y-m-d";

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
     * @param \DateTime $referenceDay
     * @param           $filename
     */
    public function createPayrollCalendar(\DateTime $referenceDay, $filename)
    {
        $handle = fopen($filename, 'w');

        $remainingMonths = $this->calendarService->getRemainingMonths(
          $referenceDay
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
            $salaryDay->format($this->csvFormat),
            $bonusDay->format($this->csvFormat),
          ]
        );
    }
}