<?php
namespace Comode\syntax;

class ComplimentFactory implements IComplimentFactory
{
    private $nodeFactory;
    private $clauseFactory;
    private $argumentFactory;
    private $answerFactory;

    public function __construct(
        node\IFactory $nodeFactory,
        IArgumentFactory $argumentFactory,
        IAnswerFactory $answerFactory
    )
    {
        $this->nodeFactory = $nodeFactory;
        $this->argumentFactory = $argumentFactory;
        $this->answerFactory = $answerFactory;
    }
    
    public function setClauseFactory(IClauseFactory $clauseFactory)
    {
        $this->clauseFactory = $clauseFactory;
    }
    
    public function provideCompliment(IArgument $argument, IAnswer $answer)
    {
        $node = $this->nodeFactory->createComplimentNode();
        
        return $this->makeCompliment($node);
    }
    
    public function provideComplimentsByClause(node\IClause $clauseNode)
    {
        $complimentNodes = $this->nodeFactory->getComplimentNodes($clauseNode);

        return $this->makeCompliments($complimentNodes);
    }
    
    public function provideComplimentsByArgument(node\IArgument $argumentNode)
    {
        $complimentNodes = $this->nodeFactory->getComplimentNodes($argumentNode);

        return $this->makeCompliments($complimentNodes);
    }
    
    public function provideComplimentsByAnswer(node\IAnswer $answerNode)
    {
        $complimentNodes = $this->nodeFactory->getComplimentNodes($answerNode);

        return $this->makeCompliments($complimentNodes);
    }
    
    private function makeCompliments(array $nodes)
    {
        $compliments = [];
        
        foreach ($nodes as $node) {
            $compliments[] = $this->makeCompliment($node);
        }
        
        return $compliments;
    }
    
    public function makeCompliment(node\ICompliment $node)
    {
        return new Compliment($this->argumentFactory, $this->answerFactory, $node);
    }
}