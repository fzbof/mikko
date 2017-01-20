<?php

namespace PayrollBundle\Service;

use PayrollBundle\Models\PayrollMonth;

/**
 * Class PaydayService
 *
 * @package PayrollBundle\Service
 */
class PaydayService implements PaydayServiceInterface
{
    /**
     * @var int[] Numbers of days considered 'weekend' (sunday = 0)
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
     * @inheritdoc
     */
    public function calculateSalaryPayday(PayrollMonth $payrollMonth)
    {
        $payDay = new \DateTime();
        $payDay->setDate(
          $payrollMonth->getYear(),
          $payrollMonth->getMonth() + 1,
          0
        );

        while (in_array($payDay->format('w'), $this->weekendDays)) {
            $payDay->sub(new \DateInterval('P1D'));
        }

        return $payDay;
    }

    /**
     * @inheritdoc
     */
    public function calculateBonusPayday(PayrollMonth $payrollMonth)
    {
        $payDay = new \DateTime();
        $payDay->setDate(
          $payrollMonth->getYear(),
          $payrollMonth->getMonth() + 1,
          $this->bonusDay
        );

        $dayOfWeek = (int)$payDay->format('w');
        if (in_array($dayOfWeek, $this->weekendDays)) {
            $payDay->add(
              new \DateInterval(
                sprintf(
                  'P%dD',
                  (7 - $dayOfWeek + $this->weekendBonusWeekday) % 7
                )
              )
            );
        }

        return $payDay;
    }
}