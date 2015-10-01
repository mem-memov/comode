<?php
namespace service\router\action\controller\template;
class Template implements ITemplate {
    
    private $templatefilePath;
    
    public function __construct($templatefilePath) {
        
        $this->templatefilePath = $templatefilePath;
        
    }
    
    public function render(array $data = array()) {
        
        ob_start();
        
        require $this->templatefilePath;
        
        $view = ob_get_clean();
        
        return $view;
        
    }
    
}