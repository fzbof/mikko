<?php

namespace PayrollBundle\Service;

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
     * @return array
     */
    public function getRemainingMonths(\DateTime $startDate);
}