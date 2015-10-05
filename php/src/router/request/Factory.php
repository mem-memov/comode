<?php
namespace WebApi\router\request;

class Factory implements IFactory
{
    private $sapi;
    private $commandLine;
    
    public function __construct(array $commandLine)
    {
        $this->sapi = php_sapi_name();
        $this->commandLine = $commandLine;
    }
    
    public function request()
    {
        $isCommandLine = $this->isCommandLine();
        
        $command = null;
        $arguments = array();
        if (!empty($this->commandLine)) {
            $command = array_unshift($this->commandLine);
            $arguments = $this->commandLine;
        }

        return new Request($_GET, $_POST, $command, $arguments);
    }
    
    private function isCommandLine()
    {
        $sapi = php_sapi_name();
        return $sapi != 'cli';
    }
}
