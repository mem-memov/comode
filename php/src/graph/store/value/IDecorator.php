<?php
namespace Comode\graph\store\value;

interface IDecorator
{
    public function makeString(IString $stringValue);
    public function makeFile(IFile $fileValue);
}