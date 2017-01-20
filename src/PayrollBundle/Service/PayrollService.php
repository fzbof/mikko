<?php

namespace PayrollBundle\Service;

use PayrollBundle\Models\PayrollMonth;

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
    private $dateOutputFormat = 'Y-m-d';

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

        foreach ($remainingMonths as $payrollMonth) {
            $this->writePaydayLine($handle, $payrollMonth);
        }

        fclose($handle);
    }

    /**
     * @param                                    $handle
     * @param \PayrollBundle\Models\PayrollMonth $payrollMonth
     */
    private function writePaydayLine($handle, PayrollMonth $payrollMonth)
    {
        $salaryDay = $this->paydayService->calculateSalaryPayday($payrollMonth);

        $bonusDay = $this->paydayService->calculateBonusPayday($payrollMonth);

        fputcsv(
          $handle,
          [
            $payrollMonth->getMonth(),
            $salaryDay->format($this->dateOutputFormat),
            $bonusDay->format($this->dateOutputFormat),
          ]
        );
    }
}