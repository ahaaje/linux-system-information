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
    protected $function;

    /**
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param string $function
     * @return void
     */
    public function setFunction($function)
    {
        $this->function = $function;
    }
}