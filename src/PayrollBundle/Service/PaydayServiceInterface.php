<?php

namespace PayrollBundle\Service;

use PayrollBundle\Models\PayrollMonth;

/**
 * Interface PaydayServiceInterface
 *
 * @package PayrollBundle\Service
 */
interface PaydayServiceInterface
{
    /**
     * Calculates the pay day of the salary for a given year and month
     *
     * @param PayrollMonth $payrollMonth
     *
     * @return \DateTime
     */
    public function calculateSalaryPayday(PayrollMonth $payrollMonth);

    /**
     * Calculates the pay day of the bonus for a given year and month
     *
     * @param PayrollMonth $payrollMonth
     *
     * @return \DateTime
     */
    public function calculateBonusPayday(PayrollMonth $payrollMonth);
}