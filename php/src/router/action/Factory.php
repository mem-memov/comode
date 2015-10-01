<?php
namespace WebApi\router\action;
class Factory implements IFactory {

    private $request;
    private $controllerFactory;
    
    public function __construct(
        \service\router\request\IRequest $request,
        \service\IFactory $serviceFactory,
        \domain\IFactory $domainFactory
    ) {
      
        $this->request = $request;
        $this->controllerFactory = new controller\Factory($serviceFactory, $domainFactory);
      
    }
    
    public function controller(array $data) {

        $instance = $this->controllerFactory->controller($data['class']);
        
        $arguments = array();
        if (array_key_exists('arguments', $data)) {
            foreach ($data['arguments'] as $requestCall) {
              $requestMethod = array_shift($requestCall);
              $requestArguments = $requestCall;
              $arguments[] = call_user_func_array(array($this->request, $requestMethod), $requestArguments);
            }
        }
        
        return new Controller($instance, $data['method'], $arguments);
      
    }
  
}