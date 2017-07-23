<?php

namespace Ahaaje\LinuxSystemInformation;


class Mount
{
    /** @var  string $device */
    private $device;
    /** @var  string $mountPoint */
    private $mountPoint;
    /** @var  string $fsType */
    private $fsType;
    /** @var  bool $isLocal True if not a network mount */
    private $isLocal;

    public function __construct($device, $mountPoint, $fsType)
    {
        $this->device = $device;
        $this->mountPoint = $mountPoint;
        $this->fsType = $fsType;

        $this->isLocal = (substr($device, 0, 1) == '/');
    }

    /**
     * Returns the device name, or remote host and directory if a network mount
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Returns the mount point directory name
     *
     * @return string
     */
    public function getMountPoint()
    {
        return $this->mountPoint;
    }

    /**
     * Get the file system type
     *
     * @return string
     */
    public function getFsType()
    {
        return $this->fsType;
    }

    /**
     * True if not a network mount
     *
     * @return bool
     */
    public function isLocal()
    {
        // TODO this needs a unit test to check correct value against device name
        return $this->isLocal;
    }
}