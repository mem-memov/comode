<?php
namespace Comode\graph;

class Configuration implements IConfiguration
{
    private $options;
    private $storeFactory;
    private $store;

    public function __construct(
        store\IFactory $storeFactory, 
        array $options
    ) {
        $this->storeFactory = $storeFactory;
        $this->options = $options;
    }

    public function makeStore()
    {
        if (is_null($this->store)) {
            
            $this->checkOptions();

            switch ($this->options['store']['type']) {
                case 'fileSystem':
                    $this->store = $this->storeFactory->makeFileSystem($this->options['store']);
                    break;
                default:
                    throw new exception\OptionUnknown('Unknown store type: ' . $this->options['store']['type']);
                    break;
            }
        }
        
        return $this->store;
    }
    
    private function checkOptions()
    {
        if (
            !isset($this->options['store']) 
            || !isset($this->options['store']['type'])
        ) {
            throw new exception\OptionMissing('Store type missing.');
        }
    }
}