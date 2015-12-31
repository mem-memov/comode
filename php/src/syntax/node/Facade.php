<?php
namespace Comode\syntax\node;

use Comode\graph\IFactory as IGraphFactory;

final class Facade extends Factory
{
    public function __construct(IGraphFactory $graphFactory, $spaceDirectory)
    {
        $typeSpace = new type\Space($graphFactory, $spaceDirectory.'/syntaxSpace.php');
        $typeChecker = new type\Checker($typeSpace);
        $creator = new type\Creator($graphFactory, $typeChecker);
        $filter = new type\Filter($typeChecker);
        $sequenceFactory = new sequence\Factory($creator, $filter);
        
        parent::__construct($creator, $filter, $sequenceFactory);
    }
    
}