<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class ComplimentFactory implements IComplimentFactory
{
    private $graphFactory;
    private $spaceMap;
    
    public function __construct(IGraphFactory $graphFactory, ISpaceMap $spaceMap)
    {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
    }
    
    public function provideStringCompliment($string)
    {
        $complimentNode = $this->graphFactory->createStringNode($string);

        $stringCompliment = new StringCompliment($complimentNode);
        
        return $stringCompliment;
    }
    
    public function provideFileCompliment($path)
    {
        $complimentNode = $this->graphFactory->createFileNode($path);

        $fileCompliment = new FileCompliment($complimentNode);
        
        return $fileCompliment;
    }
}