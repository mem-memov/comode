<?php
namespace WebApi\router\action\controller\response;
class Html implements IResponse {

    private $html;
    
    public function __construct($html) {
        
        $this->html = $html;
        
    }
    
    public function send() {
        
        echo $this->html;
        
    }
    
}