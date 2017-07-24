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
        $system = new System();
        $this->assertTrue(is_object($system));
        unset($system);
    }

    /**
     * Check that we don't receive an empty string
     */
    public function testGetHostname()
    {
        $system = new System();
        $this->assertNotEmpty($system->getHostname());
        unset($system);
    }

    /**
     * Test that the correct exception is thrown if we request a load average that does not exist
     */
    public function testGetWrongLoadAverage()
    {
        $system = new System();
        $this->expectException(\OutOfBoundsException::class);

        $system->getLoadAverage(10);
    }

    /**
     * Test that the load array is set
     */
    public function testGetLoad()
    {
        $system = new System();
        $load = $system->getLoad();
        $this->assertArrayHasKey('avg5', $load);
        $this->assertNotEmpty($load['avg5']);
    }

    /**
     * Test that the correct exception is thrown if we request a memory category that does not exist
     */
    public function testGetWrongMemoryCategory()
    {
        $system = new System();
        $this->expectException(\OutOfBoundsException::class);

        $system->getMemoryCategory('badKey');
    }

    /**
     * Check that memory info is filled, and that total memory is the sum of available and used
     */
    public function testGetMemory()
    {
        $system = new System();
        $memory = $system->getMemory();
        $this->assertArrayHasKey('available', $memory);
        $this->assertNotEmpty($memory['available']);
        $this->assertEquals($memory['total'], ($memory['available'] + $memory['used']));
        $this->assertGreaterThan(0, $memory['used'], 'Used memory can not be negative or zero');
    }
}
