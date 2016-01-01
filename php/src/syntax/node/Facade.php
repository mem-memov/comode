<?php
namespace Comode\syntax\node;

use Comode\graph\IFactory as IGraphFactory;

final class Facade extends Factory
{
    public function __construct(IGraphFactory $graphFactory, $spaceDirectory)
    {
        $typeSpace = new type\Space($graphFactory, $spaceDirectory.'/syntaxSpace.php');
        $typeChecker = new type\Checker($typeSpace);
        $filter = new type\Filter($typeChecker);
        $sequenceFactory = new sequence\Factory($graphFactory, $typeChecker, $filter);
        
        parent::__construct($graphFactory, $typeChecker, $filter, $sequenceFactory);
    }
    
}