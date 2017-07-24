<?php
namespace Ahaaje\LinuxSystemInformation\Traits;

use Ahaaje\LinuxSystemInformation\Exceptions\CommandExecutionException;
use Ahaaje\LinuxSystemInformation\Exceptions\FileAccessException;
use Ahaaje\LinuxSystemInformation\Exceptions\FileMissingException;
use Ahaaje\LinuxSystemInformation\Exceptions\FunctionMissingException;

/**
 * Trait InformationAccessTrait contains method to access information on the system
 *
 * @author Arne K. Haaje <arne@drlinux.no>
 * @package Ahaaje\LinuxSystemInformation\Traits
 */
trait InformationAccessTrait
{
    /**
     * @param string $filename
     * @param bool $asArray Return the file as an array instead of as string
     * @return mixed
     * @throws FileAccessException|FileMissingException|FunctionMissingException
     */
    private function readFile($filename, $asArray = false)
    {
        if (!is_file($filename)) {
            throw new FileMissingException($filename . ' does not exist');
        }

        if ($asArray) {
            $function = 'file';

            if (!function_exists($function)) {
                $e = new FunctionMissingException("Function $function() is missing");
                $e->setFunction($function);
                throw $e;
            }
            $contents = file($filename, FILE_IGNORE_NEW_LINES);
        }
        else {
            $function = 'file_get_contents';

            if (!function_exists($function)) {
                $e = new FunctionMissingException("Function $function() is missing");
                $e->setFunction($function);
                throw $e;
            }
            $contents = file_get_contents($filename);
        }

        if ($contents === false) {
            throw new FileAccessException($filename . ' could not be read');
        }

        return $contents;
    }

    /**
     * Execute a system command and return the output
     *
     * @param string $command
     * @return array
     * @throws FunctionMissingException|CommandExecutionException
     */
    private function readCommandOutput($command)
    {
        $output = array();
        $resultCode = null;
        $function = 'exec';

        if (!function_exists($function)) {
            $e = new FunctionMissingException("Function $function() is missing");
            $e->setFunction($function);
        }

        exec(escapeshellcmd($command), $output, $resultCode);

        if ($resultCode !== 0) {
            $e = new CommandExecutionException("The command $command exited with an error", $resultCode);
            $e->setCommand($command);

            throw $e;
        }

        return $output;
    }
}