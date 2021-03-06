<?php
// Run this file from the command line inside the examples directory with "php index.php"
require '../vendor/autoload.php';

use Ahaaje\LinuxSystemInformation\System;

try {
    $system = new System();

    echo 'Host:' . $system, PHP_EOL;
    echo 'Load average last 5 minutes: ' . $system->getLoadAverage(5), PHP_EOL;
    echo 'Total memory: ' . $system->getMemoryCategory('total', true), PHP_EOL;
    echo 'Used memory: ' . $system->getMemoryCategory('used', true), PHP_EOL;
    echo 'Available memory: ' . $system->getMemoryCategory('available', true), PHP_EOL;
    echo PHP_EOL;
    echo 'Mounted file systems', PHP_EOL;
    foreach ($system->getMounts() as $mount) {
        /** @var \Ahaaje\LinuxSystemInformation\Mount $mount */
        echo ($mount->isLocal() ? 'Local' : 'Network') . ' ' . $mount->getFsType() . ': ' . $mount->getMountPoint(), PHP_EOL;
        echo "\t size: " . $mount->getSpaceCategory('size', true) . ', used : ' . $mount->getSpaceCategory('used', true) . ', available ' . $mount->getSpaceCategory('avail', true) . ', used %' . $mount->getSpaceCategory('pcent'), PHP_EOL;
    }

} catch (\RuntimeException $e) {
    // Some stat could not be accessed
    echo get_class($e) . ' : ' . $e->getMessage(), PHP_EOL;
} catch (\Exception $e) {
    echo 'FATAL EXCEPTION: ' . $e->getMessage(), PHP_EOL;
}
