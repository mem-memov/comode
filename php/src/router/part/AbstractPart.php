<?php
namespace service\router\part;
class AbstractPart implements IPart {
  
    private $name;
    private $nextPart;
    private $action;
  
    public function __construct(
        $name
    ) {
     
        $this->name = $name;
        $this->nextPart = null;
        $this->action = null;
      
    }
    
    public function setAction(
        \service\router\action\IAction $action
    ) {
      
        $this->action = $action;
      
    }
    
    public function setNextPart(IPart $nextPart) {
      
      $this->nextPart = $nextPart;
      
    }
    
    public function run() {
      
        $result = null;
        
        if (!is_null($this->action)) {
            $result = $this->action->run();
        }

        if (is_null($result) && !is_null($this->nextPart)) {
          $result = $this->nextPart->run();
        }

        return $result;
      
    }
  
}