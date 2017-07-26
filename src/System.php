<?php 
namespace Ahaaje\LinuxSystemInformation;

/**
*  Main class for gathering system information
*
*  @author Arne K. Haaje <arne@haaje.com>
*/
class System 
{
    const FILE_HOSTNAME = '/etc/hostname';
    const FILE_LOADAVG = '/proc/loadavg';
    const FILE_MEMINFO = '/proc/meminfo';
    const FILE_MOUNTS = '/proc/mounts';

    use Traits\InformationAccessTrait;
    use Traits\NumbersConversionTrait;

    /**  @var string $hostname */
    protected $hostname = '';

    /** @var array The load average last 1, 5 and 15 minutes */
    protected $load = array();

    /** @var array Free, used and total memory (swap not included) */
    protected $memory = array();

    /** @var array All mounted file systems as Mount objects */
    protected $mounts = array();

    /**
     * System constructor.
     * @throws \DomainException if system is not Linux
     */
    public function __construct()
    {
        if (PHP_OS != 'Linux') {
            throw new \DomainException(PHP_OS . ' is not a supported operating system');
        }

        $this->hostname = rtrim($this->readFile(self::FILE_HOSTNAME));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->hostname;
    }
    
    /**
    * Get hostname
    *
    * @return string
    */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Read /proc/loadavg and set load for 1, 5 and 15 minutes
     * @return void
     */
    protected function setLoad()
    {
        if (empty($this->load)) {
            $loadAvg = explode(' ', $this->readFile(self::FILE_LOADAVG));
            $this->load['avg1'] = $loadAvg[0];
            $this->load['avg5'] = $loadAvg[1];
            $this->load['avg15'] = $loadAvg[2];
        }
    }

    /**
     * Return the load average as an array with three keys
     *
     * @return array
     */
    public function getLoad()
    {
        $this->setLoad();

        return $this->load;
    }

    /**
     * Return the load average for 1, 5 or 15 minutes
     *
     * @param int $minutes
     * @return float
     */
    public function getLoadAverage($minutes)
    {
        $averages = [1, 5, 15];
        if (!in_array($minutes, $averages)) {
            throw new \OutOfBoundsException($minutes . ' is not a valid agerage. Legal values are ' . implode(', ', $averages));
        }
        $this->setLoad();

        return $this->load['avg' . $minutes];
    }

    /**
     * Read /proc/meminfo and set total, available and used memory
     * @return void
     */
    protected function setMemory()
    {
        if (empty($this->memory)) {
            $meminfo = $this->readFile(self::FILE_MEMINFO, true);

            preg_match("/(\d+)/", $meminfo[0], $matches);
            $this->memory['total'] = $matches[1];

            preg_match("/(\d+)/", $meminfo[2], $matches);
            $this->memory['available'] = $matches[1];
            $this->memory['used'] = $this->memory['total'] - $this->memory['available'];
        }
    }

    /**
     * Return the memory info as an array with keys total, avalable and used
     *
     * @return array
     */
    public function getMemory()
    {
        $this->setMemory();

        return $this->memory;
    }

    /**
     * Return the memory info for either total, available or used
     *
     * @param string $category
     * @param bool $normalize Return the stat as "human readable"
     * @return int
     */
    public function getMemoryCategory($category, $normalize = false)
    {
        $categories = ['total', 'available', 'used'];
        if (!in_array($category, $categories)) {
            throw new \OutOfBoundsException($category . ' is not a valid memory category. Legal values are ' . implode(', ', $categories));
        }
        $this->setMemory();

        return $normalize ? $this->humanReadable($this->memory[$category]) : $this->memory[$category];
    }

    /**
     * Return an array of Mount objects for each mounted file system
     *
     * @return array
     */
    public function getMounts()
    {
        $this->setMounts();
        return $this->mounts;
    }

    /**
     * Read the file of mounted file system, and create a Mount object for each
     * @return void
     */
    public function setMounts()
    {
        if (empty($this->mounts)) {
            $mounts = $this->readFile(self::FILE_MOUNTS, true);
            foreach ($mounts as $mount) {
                $data = explode(' ', $mount);
                if (preg_match("/\//", $data[0])) {
                    $this->mounts[] = new Mount($data[0], $data[1], $data[2]);
                }
            }
        }
    }
}
?>