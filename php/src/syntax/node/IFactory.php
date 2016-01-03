<?php
namespace Comode\syntax\node;

interface IFactory
{
    public function createWordNode($value);
    public function fetchWordNode($id);
    public function getWordNodes(INode $node);
    
    public function createClauseNode();
    public function fetchClauseNode($id);
    public function getClauseNodes(INode $node);
    
    public function createPredicateNode();
    public function fetchPredicateNode($id);
    public function getPredicateNodes(INode $node);
    
    public function createArgumentNode();
    public function getArgumentNodes(INode $node);
    
    public function createQuestionNode();
    public function fetchQuestionNode($id);
    public function getQuestionNodes(INode $node);
    
    public function createComplimentNode();
    public function getComplimentNodes(INode $node);
    public function getComplimentSequence(INode $node);
    
    public function createAnswerNode();
    public function fetchAnswerNode($id);
    public function getAnswerNodes(INode $node);
}