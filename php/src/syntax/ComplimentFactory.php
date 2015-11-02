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
    
    public function createStringCompliment($string)
    {
        $answerNode = $this->graphFactory->createStringNode($string);

        $stringAnswer = new StringAnswer($string, $answerNode);
        
        return $stringAnswer;
    }
    
    public function createFileCompliment($path)
    {
        $answerNode = $this->graphFactory->createFileNode($path);

        $fileAnswer = new FileAnswer($path, $answerNode);
        
        return $fileAnswer;
    }
}