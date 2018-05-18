<?php
/**
 * Magenerds\CronProcessCheck\Setup
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

namespace Magenerds\CronProcessCheck\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @category   Magenerds
 * @package    Magenerds_CronProcessCheck
 * @subpackage Setup
 * @copyright  Copyright (c) 2018 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 * @author     Mahmood Dhia <m.dhia@techdivision.com>
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0) {
            $this->alterCronScheduleTable($setup);
        }

        $setup->endSetup();
    }

    /**
     * Alter cron_schedule table
     *
     * @param SchemaSetupInterface $setup
     * @return void
     */
    public function alterCronScheduleTable($setup)
    {
        $cronSchedule = $setup->getTable('cron_schedule');

        $columns = [
            'pid' => [
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'unsigned' => true,
                'default' => NULL,
                'comment' => 'Contains the process id of running php instance',
            ]
        ];

        $connection = $setup->getConnection();
        foreach ($columns as $name => $definition) {
            $connection->addColumn($cronSchedule, $name, $definition);
        }
    }
}