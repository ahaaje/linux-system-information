<?php

namespace Ahaaje\LinuxSystemInformation;

/**
 * Class Mount holds information on file systems mounted
 * Can be called on it's own, but System will instantiate it if you access the "space" property
 *
 * @author Arne K. Haaje <arne@drlinux.no>
 * @package Ahaaje\LinuxSystemInformation
 */
class Mount
{
    /*
     * This assumes that the command is in your path. If it is not, then you could try putting the following in your script
     * putenv('PATH=' .$_ENV['PATH']. ':/my/own/path');
     */
    const COMMAND_DF = 'df --output=size,used,avail,pcent ';

    use Traits\InformationAccessTrait;
    use Traits\NumbersConversionTrait;

    /** @var  string $device */
    protected $device;
    /** @var  string $mountPoint */
    protected $mountPoint;
    /** @var  string $fsType */
    protected $fsType;
    /** @var  bool $isLocal True if not a network mount */
    protected $isLocal;

    /** @var array $space Stats on space for thsi mount. Keys size,used,avail,pcent */
    protected $space = array();

    /**
     * Mount constructor.
     *
     * @param string $device The device file or remote host and directory (myhost:/myexport)
     * @param string $mountPoint
     * @param string $fsType
     */
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
        return $this->isLocal;
    }

    /**
     * Numbers are in kbytes
     *
     * @return array
     */
    public function getSpace()
    {
        if (empty($this->space)) {
            $this->setSpace();
        }
        return $this->space;
    }

    /**
     * Return the file system space stats (in kbytes) for either keys size,used,avail,pcent
     *
     * @param string $category
     * @param bool $normalize Return the stat as "human readable"
     * @return int
     */
    public function getSpaceCategory($category, $normalize = false)
    {
        $categories = ['keys', 'size', 'used', 'avail', 'pcent'];
        if (!in_array($category, $categories)) {
            throw new \OutOfBoundsException($category . ' is not a valid space category. Legal values are ' . implode(', ', $categories));
        }
        $this->setSpace();

        return ($normalize && $category != 'pcent') ? $this->humanReadable($this->space[$category]) : $this->space[$category];
    }

    /**
     * Fill the space array with stats in keys size,used,avail,pcent
     * @return void
     */
    protected function setSpace()
    {
        $dfSpace = $this->readCommandOutput(self::COMMAND_DF . $this->mountPoint);
        preg_match("/(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $dfSpace[1], $matches);
        $this->space['size'] = $matches[1];
        $this->space['used'] = $matches[2];
        $this->space['avail'] = $matches[3];
        $this->space['pcent'] = $matches[4];
    }
}