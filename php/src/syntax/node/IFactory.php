<?php
namespace Comode\syntax\node;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

interface IFactory
{
    public function createClauseNode();
    public function getClauseNodes(INode $node);
    
    public function createPredicateNode(array $structure);
    public function getPredicateNodes(INode $node);
    
    public function createArgumentNode();
    public function getArgumentNodes(INode $node);
    
    public function createQuestionNode(array $structure);
    public function getQuestionNodes(INode $node);
    
    public function createComplimentNode();
    public function getComplimentNodes(INode $node);
    
    public function createAnswerNode(array $structure);
    public function getAnswerNodes(INode $node);
}