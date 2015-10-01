<?php
namespace service\router\action\controller\template;
class Factory implements IFactory {
    
    private $baseDirectoryPath;
    
    public function __construct() {
        
        $this->baseDirectoryPath = realpath(__DIR__ . '/../../../../../../template');
        
    }
    
    public function template($controller, $template) {
    
        $className = get_class($controller);
        
        $classPath = substr($className, strlen('controller\\'));
        $classPath = str_replace('\\', '/', $classPath);
        
        $templateFilePath = $this->baseDirectoryPath . '/' . $classPath . '/' . $template . '.php';

        return new Template($templateFilePath);
        
    }
    
}