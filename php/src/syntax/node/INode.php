<?php
namespace Comode\syntax\node;

interface INode
{
    public function getId();
    public function addNode(INode $node);
    public function removeNode(INode $node);
    public function getNodes();
    public function hasNode(INode $node);
    public function getValue();
    public function getCommonNodes(INode $node);
}