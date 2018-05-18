<?php
/**
 * @category   Magenerds
 * @package    Magenerds_CronProcessCheck
 * @subpackage etc
 * @author     Mahmood Dhia <m.dhia@techdivision.com>
 * @copyright  Copyright (c) 2018 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Magenerds_CronProcessCheck',
    __DIR__
);