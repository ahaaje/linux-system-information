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
    protected string $command;

    /**
     * Get the command we tried to call
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     * @return void
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }
}