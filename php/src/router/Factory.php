<?php
namespace WebApi\router;
class Factory implements IFactory {

    /** @var \service\router\part\IFactory */
    private $partFactory;
    
    public function __construct(
        \service\IFactory $serviceFactory,
        \domain\IFactory $domainFactory,
        array $commandLine
    ) {

        $requestFactory = new request\Factory($commandLine);
        $actionFactory = new action\Factory($requestFactory->request(), $serviceFactory, $domainFactory);
        $this->partFactory = new part\Factory($actionFactory); 
 
    }
    
    public function phpArray($path) {
      
        $pathParts = explode('/', $path);
        $pathParts[0] = '/';

        return new PhpArray(
            $pathParts,
            realpath(__DIR__ . '/../../../routes.php'),
            $this->partFactory
        );
      
    }
}