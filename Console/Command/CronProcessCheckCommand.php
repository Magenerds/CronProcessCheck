<?php
/**
 * Magenerds\CronProcessCheck\Console\Command\CronProcessCheckCommand
 *
 * Copyright (c) 2018 TechDivision GmbH
 * All rights reserved
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany
 * For more information see http://www.techdivision.com/
 *
 * To obtain a valid license for using this software please contact us at
 * license@techdivision.com
 */

namespace Magenerds\CronProcessCheck\Console\Command;

use Magento\Cron\Model\Schedule;
use Magento\Cron\Model\ScheduleFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @category   Magenerds
 * @package    Magenerds_CronProcessCheck
 * @subpackage Console
 * @copyright  Copyright (c) 2018 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 * @author     Mahmood Dhia <m.dhia@techdivision.com>
 */
class CronProcessCheckCommand extends Command
{
    /**
     * @var ScheduleFactory
     */
    private $scheduleFactory;

    /**
     * class constructor
     *
     * @param ScheduleFactory $scheduleFactory
     */
    public function __construct(
        ScheduleFactory $scheduleFactory
    )
    {
        $this->scheduleFactory = $scheduleFactory;
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    public function configure()
    {
        $this->setName('magenerds:cronprocess:clear');
        $this->setDescription('Set the status of crashed cronjobs to error');

        parent::configure();
    }

    /**
     * Check running cronjobs
     *
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $cronList = $this->scheduleFactory->create()->getCollection()
            ->addFieldToFilter('status', Schedule::STATUS_RUNNING)
            ->addFieldToFilter('pid', ['neq' => 'NULL'])
            ->load();

        $cleanCount = 0;

        /** @var Schedule $cron */
        foreach ($cronList as $cron) {
            if ((function_exists('posix_getpgid') && posix_getpgid($cron->getPid()) === false) // try to use POSIX (Portable Operating System Interface)
                || file_exists('/proc/' . $cron->getPid()) === false // check process pid in /proc/ folder
            ) {
                $cleanCount++;
                $cron->setMessages(sprintf('Magenerds_CronProcessCheck: Process (PID: %s) is gone', $cron->getPid()));
                $cron->setStatus(Schedule::STATUS_ERROR);
                $cron->save();
            }
        }

        $output->writeln(sprintf('Cleaned %s cronjobs', $cleanCount));
        return 0;
    }
}
