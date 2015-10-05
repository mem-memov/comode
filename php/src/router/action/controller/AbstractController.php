<?php
namespace WebApi\router\action\controller;

abstract class AbstractController
{
    protected $serviceFactory;
    protected $domainFactory;
    protected $controllerFactory;
    protected $responseFactory;
    protected $templateFactory;
    
    public function __construct(
        \service\IFactory $serviceFactory,
        \domain\IFactory $domainFactory,
        IFactory $controllerFactory,
        response\IFactory $responseFactory,
        template\IFactory $templateFactory
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->domainFactory = $domainFactory;
        $this->controllerFactory = $controllerFactory;
        $this->responseFactory = $responseFactory;
        $this->templateFactory = $templateFactory;
    }
}
