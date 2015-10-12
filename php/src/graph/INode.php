<?php
namespace Comode\graph;

interface INode
{
    public function getId();
    public function addNode(INode $node);
    public function getNodes();
    public function hasNode(INode $node);
    public function getValue();
    public function getCommonNodes(INode $node);
}
