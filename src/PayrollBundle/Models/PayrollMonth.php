<?php

namespace PayrollBundle\Models;

class PayrollMonth
{
    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $month;

    /**
     * Month constructor.
     *
     * @param int $year
     * @param int $month
     */
    function __construct($year, $month)
    {
        $this->year  = $year;
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     *
     * @return PayrollMonth
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @param int $month
     *
     * @return PayrollMonth
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }
}