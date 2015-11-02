<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface ISpaceMap
{
    public function isClauseNode(INode $node);
    public function getClauseNodes(INode $node);
    
    public function isPredicateNode(INode $node);
    public function getPredicateNodes(INode $node);
    
    public function isArgumentNode(INode $node);
    public function getArgumentNodes(INode $node);
    
    public function isQuestionNode(INode $node);
    public function getQuestionNodes(INode $node);
    
    public function isComplimentNode(INode $node);
    public function getComplimentNodes(INode $node);
}