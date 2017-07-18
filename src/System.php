<?php 
namespace Ahaaje\LinuxSystemInformation;
use Ahaaje\LinuxSystemInformation\Exceptions\FileAccessException;
use Ahaaje\LinuxSystemInformation\Exceptions\FileMissingException;

/**
*  Main class for gathering system information
*
*  @author Arne K. Haaje <arne@haaje.com>
*/
class System 
{
    /**  @var string $hostname */
    private $hostname = '';

    /** @var array The load average last 1, 5 and 15 minutes */
    private $load = array();

    /**
     * System constructor.
     * @throws \DomainException if system is not Linux
     */
    public function __construct()
    {
        if (PHP_OS != 'Linux') {
            throw new \DomainException(PHP_OS . ' is not a supported operating system');
        }

        $this->hostname = $this->readFile('/etc/hostname');
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
     * @param string $filename
     * @return string
     * @throws FileAccessException|FileMissingException
     */
    private function readFile($filename)
    {
        if (!is_file($filename)) {
            throw new FileMissingException($filename . ' does not exist');
        }

        $contents = file_get_contents($filename);

        if ($contents === false) {
            throw new FileAccessException($filename . ' could not be read');
        }

        return rtrim($contents);
    }

    /**
     * Read /proc/loadavg and set load for 1, 5 and 15 minutes
     */
    private function setLoad()
    {
        if (empty($this->load)) {
            $loadAvg = explode(' ', $this->readFile('/proc/loadavg'));
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
}
?>