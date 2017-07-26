<?php

namespace Ahaaje\LinuxSystemInformation;


class Mount
{
    use Traits\InformationAccessTrait;
    use Traits\NumbersConversionTrait;

    /** @var  string $device */
    private $device;
    /** @var  string $mountPoint */
    private $mountPoint;
    /** @var  string $fsType */
    private $fsType;
    /** @var  bool $isLocal True if not a network mount */
    private $isLocal;

    /** @var array $space Stats on space for thsi mount. Keys size,used,avail,pcent */
    private $space = array();

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
     */
    private function setSpace()
    {
        $dfSpace = $this->readCommandOutput('df --output=size,used,avail,pcent ' . $this->mountPoint);
        preg_match("/(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $dfSpace[1], $matches);
        $this->space['size'] = $matches[1];
        $this->space['used'] = $matches[2];
        $this->space['avail'] = $matches[3];
        $this->space['pcent'] = $matches[4];
    }
}