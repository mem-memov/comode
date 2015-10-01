<?php
namespace WebApi\router\action;
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
     * @return \WebApi\routerIResponse
     */
    public function run() {
      //var_dump(get_class($this->controller));      
        $response = call_user_func_array(array($this->controller, $this->method), $this->arguments);
        
        return $response;
      
    }
  
}