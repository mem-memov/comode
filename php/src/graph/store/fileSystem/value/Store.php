<?php
namespace Comode\graph\store\fileSystem\value;

use Comode\graph\store\value\IFactory as IValueFactory;
use Comode\graph\store\fileSystem\directory\IDirectory;

class Store implements IStore
{
    private $valueFactory;
    private $strategyFactory;

    public function __construct(
        IValueFactory $valueFactory,
        stretegy\IFactory $strategyFactory
    ) {
        $this->valueFactory = $valueFactory;
        $this->strategyFactory = $strategyFactory;
    }
    
    private function create(array $structure)
    {
        $strategy = $this->valueFactory->make($structure, $this->strategyFactory);
        return $strategy->create();
    }
    
    public function bindNode($valueHash, IDirectory $nodeDirectory)
    {
        $this->nodeIndex
            ->directory($valueHash)
            ->link($nodeDirectory->name())
            ->create($nodeDirectory->path());
    }
    
    public function getNode(array $structure)
    {
        $strategy = $this->valueFactory->make($structure, $this->strategyFactory);
        return $strategy->getNode();
    }
    
    public function makeValue(array $structure)
    {
        $storeValue = $this->valueFactory->make($structure);
        
        //return new strategy\
        
        /*if (!$isFile) {
            $value = new StoreValue(false, $content);
        } else {
            $valueHash = $this->hash->hashFile($content);
            $valueDirectory = $this->valueDirectory->directory($valueHash);
            $valuePaths = $valueDirectory->paths();
            
            $valuePath = $valuePaths[0];
            $value = new StoreValue(true, $valuePath);
        }
        
        return $value;*/
    }
}