<?php
use Ahaaje\LinuxSystemInformation\Mount;

/**
 *  Corresponding Class to test the Mount class
 *
 *  @author Arne K. Haaje <arne@drlinux.no>
 */
class MountTest extends PHPUnit_Framework_TestCase
{
    /**
     * Just check if Mount has no syntax error
     *
     */
    public function testIsThereAnySyntaxError()
    {
        $mount = new Mount('/dev/sda1', '/', 'ext4');
        $this->assertTrue(is_object($mount));
        unset($mount);
    }

    /**
     * Check that we don't receive an empty string
     */
    public function testGetFsType()
    {
        $mount = new Mount('/dev/sda1', '/', 'ext4');
        $this->assertNotEmpty($mount->getFsType());
        unset($mount);
    }

    /**
     * Check that we don't receive an empty string
     */
    public function testGetMountPoint()
    {
        $mount = new Mount('/dev/sda1', '/', 'ext4');
        $this->assertNotEmpty($mount->getMountPoint());
        unset($mount);
    }

    /**
     * Check that we don't receive an empty string
     */
    public function testGetDevice()
    {
        $mount = new Mount('/dev/sda1', '/', 'ext4');
        $this->assertNotEmpty($mount->getDevice());
        unset($mount);
    }

    /**
     * Check that we correctly determine if the file system is local or network mounted
     */
    public function testIsLocal()
    {
        $mount = new Mount('/dev/sda1', '/', 'ext4');
        $this->assertTrue($mount->isLocal());
        unset($mount);

        $mount = new Mount('my.server:/exports/data', '/mnt/data', 'nfs');
        $this->assertFalse($mount->isLocal());
        unset($mount);
    }

    /**
     * Test that the correct exception is thrown if we request a space category that does not exist
     */
    public function testGetWrongSpaceCategory()
    {
        $mount = new Mount('/dev/sda1', '/', 'ext4');
        $this->expectException(\OutOfBoundsException::class);

        $mount->getSpaceCategory('badKey');
    }

    /**
     * Check that space info is filled
     */
    public function testGetSpace()
    {
        $mount = new Mount('/dev/sda1', '/', 'ext4');
        $space = $mount->getSpace();
        $this->assertArrayHasKey('avail', $space);
        $this->assertNotEmpty($space['avail']);
    }
}
