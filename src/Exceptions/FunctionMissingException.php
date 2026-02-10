<?php

namespace Ahaaje\LinuxSystemInformation\Exceptions;

/**
 * Class FunctionMissingException thrown if we try to use a function which does not exist
 * Some functions, like "exec()" might be disabled by server configuration
 *
 * @author Arne K. Haaje <arne@drlinux.no>
 * @package Ahaaje\LinuxSystemInformation\Exceptions
 */
class FunctionMissingException extends \RuntimeException
{
    /** @var  string $function */
    protected string $function;

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @param string $function
     * @return void
     */
    public function setFunction(string $function): void
    {
        $this->function = $function;
    }
}