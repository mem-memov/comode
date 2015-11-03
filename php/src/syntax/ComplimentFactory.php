<?php
namespace Comode\syntax;

class ComplimentFactory implements IComplimentFactory
{
    private $nodeFactory;
    
    public function __construct(
        node\IFactory $nodeFactory
    ) {
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