<?php
namespace Comode\node;

interface INode
{
	public function getId();
	public function addNode(INode $node);
        public function getChildNodes();
        public function getValue();
}