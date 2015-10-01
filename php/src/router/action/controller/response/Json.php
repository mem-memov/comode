<?php
namespace service\router\action\controller\response;
class Ajax implements IResponse {

    private $data;
    
    public function __construct($data) {
        
        $this->data = $data;
        
    }
    
    public function send() {
        
        $json = json_encode($this->data);
        
        echo $json;
        
    }
    
}