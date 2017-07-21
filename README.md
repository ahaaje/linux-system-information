Linux System Information
=========================
[![Latest Stable Version](https://poser.pugx.org/ahaaje/linux-system-information/v/stable)](https://packagist.org/packages/ahaaje/linux-system-information)
[![License](https://poser.pugx.org/ahaaje/linux-system-information/license)](https://packagist.org/packages/ahaaje/linux-system-information)
[![composer.lock](https://poser.pugx.org/ahaaje/linux-system-information/composerlock)](https://packagist.org/packages/ahaaje/linux-system-information)

This is a light-weight library to gather information (stats) about the Linux system it is running on.

The information is read from the files in /proc/* and /etc/*. These are usually world readable, but your system may vary. There is no dependency on `system` or `exec`calls to binaries installed on your system.


Features
--------

* PSR-4 autoloading compliant structure
* Example file

Stats that can be fetched
-------------------------
- hostname
- load average (for 1, 5 or 15 minutes)
- memory as total, available and used

### Requirements
 - Linux
 - PHP 5.5
 
### Installation
With [composer](https://getcomposer.org/) simply do `composer require ahaaje/linux-system-information` inside your project directory.

### Usage
This is from the example file. You should not need to require the auto loader if already using composer to manage your project requirements

```php
<?php
require '../vendor/autoload.php';

use Ahaaje\LinuxSystemInformation\System;

try {
    $system = new System();

    echo 'Host:' . $system, PHP_EOL;
    echo 'Load average last 5 minutes: ' . $system->getLoadAverage(5), PHP_EOL;
    echo 'Total memory: ' . $system->getMemoryCategory('total'), PHP_EOL;
    echo 'Used memory: ' . $system->getMemoryCategory('used'), PHP_EOL;
    echo 'Available memory: ' . $system->getMemoryCategory('available'), PHP_EOL;
} catch (\RuntimeException $e) {
    // Some stat could not be accessed
    echo get_class($e) . ' : ' . $e->getMessage(), PHP_EOL;
} catch (\Exception $e) {
    echo 'FATAL EXCEPTION: ' . $e->getMessage(), PHP_EOL;
}

```
