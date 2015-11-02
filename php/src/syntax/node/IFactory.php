<?php
namespace Comode\syntax\node;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

interface IFactory
{
    public function createClauseNode();
    public function getClauseNodes(INode $node);
    
    public function createPredicateNode($predicateString);
    public function getPredicateNodes(INode $node);
    
    public function createArgumentNode();
    public function getArgumentNodes(INode $node);
    
    public function createQuestionNode($questionString);
    public function getQuestionNodes(INode $node);
    
    public function createStringComplimentNode($string);
    public function createFileComplimentNode($path);
    public function getComplimentNodes(INode $node);
}