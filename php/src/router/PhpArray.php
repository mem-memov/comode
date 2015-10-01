<?php
namespace service\router;
class PhpArray implements IRouter {
  
    private $partFactory;
    private $route;
  
    public function __construct(
        array $pathNames,
        $routeFilePath,
        part\IFactory $partFactory
    ) {
      
        $this->partFactory = $partFactory;
        
        $data = require $routeFilePath;
        $this->route = $this->partFactory->make($pathNames, $data);
      
    }
    
    public function run() {
      
        return $this->route->run();
      
    }
  
}