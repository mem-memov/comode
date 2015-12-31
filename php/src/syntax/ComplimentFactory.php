<?php
namespace Comode\syntax;

final class ComplimentFactory implements IComplimentFactory
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
        try {
            
            $compliment = $argument->provideComplimentByAnswer($answer);
            
        } catch (exception\ArgumentAndAnswerHaveOneCommonCompliment $e) {
            
            $complimentNode = $this->nodeFactory->createComplimentNode();
            $argument->addCompliment($complimentNode);
            $answer->addCompliment($complimentNode);
            $compliment = $this->makeCompliment($complimentNode);
        }

        return $compliment;
    }
    
    public function provideComplimentsByClause(node\IClause $clauseNode)
    {
        $complimentNodes = $this->nodeFactory->getComplimentNodes($clauseNode);

        return $this->makeCompliments($complimentNodes);
    }

    public function provideFirstComplimentInClause(node\sequence\ICompliment $complimentSequence)
    {
        list($firstPreviousNode, $firstNextNode, $complimentNode) = $complimentSequence->firstNodePath();
        
        return $this->makeCompliment($complimentNode);
    }

    public function provideLastComplimentInClause(node\sequence\ICompliment $complimentSequence)
    {
        list($lastNextNode, $lastPreviousNode, $complimentNode) = $complimentSequence->lastNodePath();
        
        return $this->makeCompliment($complimentNode);
    }

    public function provideNextComplimentInClause(node\sequence\ICompliment $complimentSequence, node\ICompliment $complimentNode)
    {
        list($originNode, $originNextNode, $targetNextNode, $targetNode) = $complimentSequence->nextNodePath($complimentNode);
        
        return $this->makeCompliment($targetNode);
    }

    public function providePreviousComplimentInClause(node\sequence\ICompliment $complimentSequence, node\ICompliment $complimentNode)
    {
        list($originNode, $originPreviousNode, $targetPreviousNode, $targetNode) = $complimentSequence->previousNodePath($complimentNode);
        
        return $this->makeCompliment($targetNode);
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
        return new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $node);
    }
}