<?php

namespace PayrollBundle\Service;

/**
 * Class PaydayService
 *
 * @package PayrollBundle\Service
 */
class PaydayService
{
    /**
     * @var int[]
     */
    private $weekendDays = [0, 6];

    /**
     * @var int Day of the next month to pay the bonuses
     */
    private $bonusDay = 15;

    /**
     * @var int Day of the week to pay the bonuses in case bonusDay falls in
     *      the weekend
     */
    private $weekendBonusWeekday = 3;

    /**
     * Calculates the pay day of the salary for a given year and month
     *
     * @param int $year  Year in YYYY format
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

    /**
     * Calculates the pay day of the bonus for a given year and month
     *
     * @param int $year  Year in YYYY format
     * @param int $month Month in MM format
     *
     * @return \DateTime
     */
    public function calculateBonusPayday(int $year, int $month)
    {
        $payDay = new \DateTime();
        $payDay->setDate($year, $month + 1, $this->bonusDay);

        $dayOfWeek = (int)$payDay->format("w");
        if (in_array($dayOfWeek, $this->weekendDays)) {
            $payDay->add(
              new \DateInterval(
                sprintf(
                  "P%dD",
                  (7 - $dayOfWeek + $this->weekendBonusWeekday) % 7
                )
              )
            );
        }

        return $payDay;
    }
}