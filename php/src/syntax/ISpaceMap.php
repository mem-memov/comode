<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface ISpaceMap
{
    public function createClauseNode();
    public function isClauseNode(INode $node);
    public function getClauseNodes(INode $node);
    
    public function createPredicateNode($predicateString);
    public function isPredicateNode(INode $node);
    public function getPredicateNodes(INode $node);
    
    public function createArgumentNode();
    public function isArgumentNode(INode $node);
    public function getArgumentNodes(INode $node);
    
    public function createQuestionNode($questionString);
    public function isQuestionNode(INode $node);
    public function getQuestionNodes(INode $node);
    
    public function createStringComplimentNode($string);
    public function createFileComplimentNode($path);
    public function isComplimentNode(INode $node);
    public function getComplimentNodes(INode $node);
}