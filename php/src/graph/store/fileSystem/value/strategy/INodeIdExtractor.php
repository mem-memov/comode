<?php
namespace Comode\graph\store\fileSystem\value\strategy;

interface INodeIdExtractor
{
    public function extractId(array $nodeIds);
}