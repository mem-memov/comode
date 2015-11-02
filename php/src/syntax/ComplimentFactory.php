<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class ComplimentFactory implements IComplimentFactory
{
    private $graphFactory;
    private $nodeFactory;
    
    public function __construct(
        IGraphFactory $graphFactory, 
        node\IFactory $nodeFactory
    ) {
        $this->graphFactory = $graphFactory;
        $this->nodeFactory = $nodeFactory;
    }
    
    public function provideStringCompliment($string)
    {
        $complimentNode = $this->nodeFactory->createStringComplimentNode($string);

        $stringCompliment = new StringCompliment($complimentNode);
        
        return $stringCompliment;
    }
    
    public function provideFileCompliment($path)
    {
        $complimentNode = $this->nodeFactory->createFileComplimentNode($path);

        $fileCompliment = new FileCompliment($complimentNode);
        
        return $fileCompliment;
    }
}