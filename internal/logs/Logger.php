<?php

/**
 * Logger Class Definition file
 * @package Core
 * @subpackage Logs
 */

namespace polux\CorePHP\Logs;

/**
 * Logger Class Definition
 */
class Logger {

    protected $loggerID = null;

    protected $filename = null;

    protected $filepath = null;

    private $filehandler = null;

    /**
     * Default Constructor of a Logger Object
     *
     * @return Logger
     */
    public function __construct($loggerID,$outputpath=null,$dateprefix=null)
    {
      $this->loggerID = $loggerID;

      if(!is_null($outputpath))
      {
        $this->filepath = $outputpath;
      }
     
      if(is_null($dateprefix))
      {
        $dateprefix = true;
      }

      $this->updateFilenameCompletePath($dateprefix);

      try{
        $this->filehandler = fopen($this->filename,'a');
        // TODO Gestion erreur d'ouverture ...
      }catch(\Exception $ex){

      }

    }//end __construct()


    public function logMessage($message)
    {
      if(is_null($this->filehandler))
      {
        throw new \Exception("Message can't be log because the logger isn't correctly initiliazed.");
      }

      fwrite($this->filehandler,$this->getMessageFormatedToLog($message));
    }//end logMessage()

    protected function getMessageFormatedToLog($message)
    {
      return '[ '.date('Ymd-H:i:s').' ] - '.$message.PHP_EOL;
    }

    /**
     * updateFilenameCompletePath
     *
     * Update complete filename to used.
     * @param boolean $dateprefix if TRUE - DateHourMinute will prefix the fiename returs.
     *
     *
     */
    private function updateFilenameCompletePath($dateprefix)
    {
      $lFilename =  $this->filepath.'/';
      if($dateprefix==true)
      {
        $lFilename .= date('Ymd-H')."_";
      }
      $lFilename .=  strtolower($this->loggerID).'.log';
      $this->filename = $lFilename;
    }//end updateFilenameCompletePath()

/*
$data = 'some data'.PHP_EOL;
$fp = fopen('somefile', 'a');
fwrite($fp, $data);
*/
    /**
     * Destructor of a Logger Object
     */
    public function __destruct(){
      if(!is_null($this->filehandler))
      {
        fclose($this->filehandler);
      }
    }//end __construct()


}//end class
?>
