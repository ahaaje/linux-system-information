<?php
require '../vendor/autoload.php';

use Ahaaje\LinuxSystemInformation\System;

try {
    $system = new System();

    echo $system, PHP_EOL;
    echo $system->getLoadAverage(5), PHP_EOL;
} catch (\RuntimeException $e) {
    // Some stat could not be accessed
    echo get_class($e) . ' : ' . $e->getMessage(), PHP_EOL;
} catch (\Exception $e) {
    echo 'FATAL EXCEPTION: ' . $e->getMessage(), PHP_EOL;
}
