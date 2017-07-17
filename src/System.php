<?php 
namespace Ahaaje\LinuxSystemInformation;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author Arne K. Haaje <arne@haaje.com>
*/
class System 
{

   /**  @var string $hostname */
   private $hostname = '';
 
    public function __construct()
    {
        // TODO check that we are actually on Linux
        $this->hostname = rtrim(file_get_contents('/etc/hostname', false, null, 0, 1024));
    }
    
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
}
?>
