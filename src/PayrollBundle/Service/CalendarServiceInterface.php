<?php

namespace PayrollBundle\Service;

use PayrollBundle\Models\PayrollMonth;

/**
 * Interface CalendarServiceInterface
 *
 * @package PayrollBundle\Service
 */
interface CalendarServiceInterface
{
    /**
     * Returns all the remaining months of a year for a given startdate, as
     * year-number/month-number pairs
     *
     * @param \DateTime $startDate
     *
     * @return PayrollMonth[]
     */
    public function getRemainingMonths(\DateTime $startDate);
}