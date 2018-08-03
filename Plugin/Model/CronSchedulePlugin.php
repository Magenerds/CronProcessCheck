<?php
/**
 * Magenerds\CronProcessCheck\Plugin\Model\CronSchedulePlugin
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

namespace Magenerds\CronProcessCheck\Plugin\Model;

use Magento\Cron\Model\Schedule;

/**
 * @category   Magenerds
 * @package    Magenerds_CronProcessCheck
 * @subpackage Model
 * @copyright  Copyright (c) 2018 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 * @author     Mahmood Dhia <m.dhia@techdivision.com>
 */
class CronSchedulePlugin
{
    /**
     * Set the job PID if can lock.
     *
     * @param Schedule $subject
     * @param bool $canLock
     * @return bool
     */
    public function afterTryLockJob(Schedule $subject, $canLock)
    {
        if ($canLock) {
            $subject->setPid(getmypid());
        }

        return $canLock;
    }
}