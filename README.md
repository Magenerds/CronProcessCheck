# CronProcessCheck
Cron Process check for Magento 2. This modules checks if a cron job process crashed and sets its status to error.

### Setup
1. Activate POSIX module in your php.ini
2. Install `Magenerds/CronProcessCheck` Module
3. Add System cronjob `* * * * * /var/www/magento/bin/magento magenerds:cronprocess:clear > /dev/null 2>&1g`
