# CronProcessCheck
Cron Process check for Magento 2. This modules checks if a cron job process crashed and sets its status to error.

### Setup
1. Install `Magenerds/CronProcessCheck` Module
2. Add System cronjob `* * * * * /var/www/magento/bin/magento magenerds:cronprocess:check > /dev/null 2>&1g`
