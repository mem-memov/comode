<?php
namespace WebApi\router\part;
class Factory implements IFactory {
  
    private $actionFactory;
    
    public function __construct(
        \service\router\action\IFactory $actionFactory
    ) {
      
        $this->actionFactory = $actionFactory;
      
    }
    
    public function make(array $partNames, array $data) {
      
        $name = array_shift($partNames);
        $partData = $data[$name];

        $factoryMethod = $partData['type'];
        $part = $this->$factoryMethod($name, $data);
        
        if (array_key_exists('items', $partData) && !empty($partNames)) {
            $nextPart = $this->make($partNames, $partData['items']);
            $part->setNextPart($nextPart);
        }

        if (array_key_exists('action', $partData)) {
            $action = $this->actionFactory->controller($partData['action']);
            $part->setAction($action);
        }
        
        return $part;
      
    }
  
    private function directory(
        $name, 
        array $data
    ) {
      
        return new Directory($name);
      
    }
    
    private function file(
        $name, 
        array $data
    ) {
      
        return new File($name);
      
    }
    
    private function root(
        $name, 
        array $data
    ) {
      
        return new Root($name);
      
    }
  
}