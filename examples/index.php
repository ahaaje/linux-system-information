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
