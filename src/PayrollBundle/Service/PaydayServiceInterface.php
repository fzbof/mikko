<?php

namespace PayrollBundle\Service;

interface PaydayServiceInterface
{
    /**
     * Calculates the pay day of the salary for a given year and month
     *
     * @param int $year  Year in YYYY format
     * @param int $month Month in MM format
     *
     * @return \DateTime
     */
    public function calculateSalaryPayday(int $year, int $month);

    /**
     * Calculates the pay day of the bonus for a given year and month
     *
     * @param int $year  Year in YYYY format
     * @param int $month Month in MM format
     *
     * @return \DateTime
     */
    public function calculateBonusPayday(int $year, int $month);
}