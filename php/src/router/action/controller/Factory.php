<?php
namespace WebApi\router\action\controller;

class Factory implements IFactory
{
    private $responseFactory;
    private $templateFactory;
    
    public function __construct() {
        $this->responseFactory = new response\Factory();
    }
    
    public function controller($name)
    {
        $class = '\controller\\' . $name;

        return new $class(
            $this,
            $this->responseFactory
        );
    }
}
