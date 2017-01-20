<?php

namespace PayrollBundle\Service;

/**
 * Class PaydayService
 * @package PayrollBundle\Service
 */
class PaydayService
{
    /**
     * @var int[]
     */
    private $weekendDays = [0, 6];

    /**
     * Calculates the pay day of the salary for a given year and month
     *
     * @param int $year Year in YYYY format
     * @param int $month Month in MM format
     *
     * @return \DateTime
     */
    public function calculateSalaryPayday(int $year, int $month)
    {
        $payDay = new \DateTime();
        $payDay->setDate($year, $month + 1, 0);

        while (in_array($payDay->format("w"), $this->weekendDays)) {
            $payDay->sub(new \DateInterval("P1D"));
        }

        return $payDay;
    }
}