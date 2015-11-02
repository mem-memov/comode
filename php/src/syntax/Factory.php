<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private $statementFactory;
    
    public function __construct(array $config, IGraphFactory $graphFactory)
    {
        $spaceMap = new SpaceMap($graphFactory, $config['spaceDirectory']);
        
        $questionFactory = new QuestionFactory($graphFactory, $spaceMap);
        $complimentFactory = new ComplimentFactory($graphFactory, $spaceMap);
        $argumentFactory = new ArgumentFactory($graphFactory, $questionFactory, $complimentFactory, $spaceMap);
        $this->sentenceFactory = new SentenceFactory($graphFactory, $argumentFactory, $spaceMap);
    }
    
    public function createSentence()
    {
        $sentence = $this->sentenceFactory->createSentence();
        
        return $sentence;
    }

}