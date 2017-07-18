<?php
use Ahaaje\LinuxSystemInformation\System;

/**
 *  Corresponding Class to test YourClass class
 *
 *  For each class in your library, there should be a corresponding Unit-Test for it
 *  Unit-Tests should be as much as possible independent from other test going on.
 *
 *  @author Arne K. Haaje <arne@drlinux.no>
 */
class SystemTest extends PHPUnit_Framework_TestCase
{
    /**
     * Just check if the YourClass has no syntax error
     *
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new System();
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * Check that we don't receive an empty string
     */
    public function testGetHostname()
    {
        $var = new System();
        $this->assertNotEmpty($var->getHostname());
        unset($var);
    }

    /**
     * Test that the correct exception is thrown if we request a load average that does not exist
     */
    public function testGetWrongLoadAverage()
    {
        $var = new System();
        $this->expectException(\OutOfBoundsException::class);

        $var->getLoadAverage(10);
    }

    // TODO add test for correct load
}
