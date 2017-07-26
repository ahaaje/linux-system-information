<?php
namespace Ahaaje\LinuxSystemInformation\Traits;

/**
 * Trait NumbersConversionTrait for making numbers more readable
 *
 * @package Ahaaje\LinuxSystemInformation\Traits
 */
trait NumbersConversionTrait
{
    /**
     * Return the number as "human readable" to nearest MB, GB or TB
     * @param int $kBytes
     * @return string
     */
    public function humanReadable($kBytes)
    {
        $bytes = $kBytes * 1024;
        $type2power = [
            'KB' => 10,
            'MB' => 20,
            'GB' => 30,
            'TB' => 40
        ];

        $hrValue = $bytes . 'b';

        foreach ($type2power as $type => $power) {
            /** @var int $one This is 1 KB, MB, GB or TB in bytes */
            $one = pow(2, $power);
            $result = round($bytes / $one, 1);
            if ($result < 1) {
                break;
            }
            $hrValue = $result . $type;
        }

        return $hrValue;
    }
}