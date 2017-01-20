<?php

namespace PayrollBundle\Service;

use PayrollBundle\Models\PayrollMonth;

/**
 * Class CalenderService
 *
 * @package PayrollBundle\Service
 */
class CalendarService implements CalendarServiceInterface
{
    /**
     * @inheritdoc
     */
    public function getRemainingMonths(\DateTime $startDate)
    {
        $remainingMonths = [];

        $startYear = $startDate->format('Y');

        $referenceDate = clone($startDate)->modify('first day of this month');
        while ($referenceDate->format('Y') == $startYear) {
            $remainingMonths[] = new PayrollMonth($startYear, $referenceDate->format('m'));
            $referenceDate->add(new \DateInterval('P1M'));
        }

        return $remainingMonths;
    }
}