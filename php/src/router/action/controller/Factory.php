<?php
namespace service\router\action\controller;
class Factory implements IFactory {

    private $serviceFactory;
    private $domainFactory;
    private $responseFactory;
    private $templateFactory;
    
    public function __construct(
        \service\IFactory $serviceFactory, 
        \domain\IFactory $domainFactory
    ) {
        
        $this->serviceFactory = $serviceFactory;
        $this->domainFactory = $domainFactory;
        $this->responseFactory = new response\Factory();
        $this->templateFactory = new template\Factory();
        
    }
    
    public function controller($name) {
      
        $class = '\controller\\' . $name;

        return new $class(
            $this->serviceFactory,
            $this->domainFactory,
            $this,
            $this->responseFactory,
            $this->templateFactory
        );
      
    }
    
}