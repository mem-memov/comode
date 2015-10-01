<?php
namespace WebApi\router\request;
class Request implements IRequest {
  
    private $post;
    private $get;
    private $command;
    private $arguments;
    
    
    public function __construct(array $get, array $post, /*string|null*/ $command, array $arguments) {
        
        $this->get = $get;
        $this->post = $post;
        $this->command = $command;
        $this->arguments = $arguments;
      
    }
    
    public function hasPost($parameter) {
        
        return array_key_exists($parameter, $this->post);
        
    }
    
    public function post($parameter, $default = null) {
     
        if (!$this->hasPost($parameter)) {
            return $default;
        }
        
        return $this->post[$parameter];
        
    }
    
    public function hasGet($parameter) {
        
        return array_key_exists($parameter, $this->get);
        
    }
    
    public function get($parameter, $default = null) {
        
        if (!$this->hasGet($parameter)) {
            return $default;
        }
        
        return $this->get[$parameter];
        
    }
    
    public function isCommandLine() {
      
        $sapi = php_sapi_name();
        return $sapi == 'cli';
        
    }
    
    public function command() {
      
        return $this->command;
      
    }
    
    public function arguments() {
      
        return $this->arguments;
      
    }
  
}