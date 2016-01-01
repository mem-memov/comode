<?php
namespace Comode\syntax\node;

interface IFactory
{
    public function createClauseNode();
    public function getClauseNodes(INode $node);
    
    public function createPredicateNode($value);
    public function getPredicateNodes(INode $node);
    
    public function createArgumentNode();
    public function getArgumentNodes(INode $node);
    
    public function createQuestionNode($value);
    public function getQuestionNodes(INode $node);
    
    public function createComplimentNode();
    public function getComplimentNodes(INode $node);
    public function getComplimentSequence(INode $node);
    
    public function createAnswerNode($value);
    public function getAnswerNodes(INode $node);
}