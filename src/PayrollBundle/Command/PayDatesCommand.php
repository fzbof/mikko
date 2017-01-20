<?php

namespace PayrollBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Debug\Exception\ContextErrorException;

class PayDatesCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
          ->setName('payroll:paydates')
          ->setDescription(
            'Outputs the salary and bonus pay dates until the end of the year to a csv-file'
          )
          ->addOption(
            'output',
            'o',
            InputOption::VALUE_OPTIONAL,
            'location of the csv-file to write to',
            'var/payroll.csv'
          )
          ->addOption(
            'startdate',
            null,
            InputOption::VALUE_OPTIONAL,
            'Startdate for the payroll calendar',
            'now'
          );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputFile = $input->getOption('output');
        $startDate  = new \DateTime($input->getOption('startdate'));

        $payrollService = $this->getContainer()->get('payroll.service.payroll');

        try {
            $payrollService->createPayrollCalendar($startDate, $outputFile);
            $output->writeln(
              sprintf(
                'Payroll calendar successfully written to %s',
                $outputFile
              )
            );
        } catch (ContextErrorException $e) {
            $output->writeln(sprintf('Could not write to %s', $outputFile));
        }
    }

}
