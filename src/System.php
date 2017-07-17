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
}
?>