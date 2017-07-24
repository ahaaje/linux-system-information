<?php
namespace Ahaaje\LinuxSystemInformation\Exceptions;

/**
 * Class CommandExecutionException thrown if the command exited with an error
 *
 * @author Arne K. Haaje <arne@drlinux.no>
 * @package Ahaaje\LinuxSystemInformation\Exceptions
 */
class CommandExecutionException extends \RuntimeException
{
    /** @var  string $command */
    protected $command;

    /**
     * Get the command we tried to call
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }
}