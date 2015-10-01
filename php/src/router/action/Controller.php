<?php
namespace service\router\action;
class Controller implements IAction {
    
    private $controller;
    private $method;
    private $arguments;
  
    public function __construct(
        $controller, 
        $method, 
        array $arguments
    ) {
      
        $this->controller = $controller;
        $this->method = $method;
        $this->arguments = $arguments;
      
    }
    
    /**
     * 
     * @return \service\router\IResponse
     */
    public function run() {
      //var_dump(get_class($this->controller));      
        $response = call_user_func_array(array($this->controller, $this->method), $this->arguments);
        
        return $response;
      
    }
  
}