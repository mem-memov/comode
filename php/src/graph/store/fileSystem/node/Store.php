<?php
namespace Comode\graph\store\fileSystem\node;

use Comode\graph\store\fileSystem\directory\IDirectory;
use Comode\graph\store\Value as StoreValue;
use Comode\graph\store\exception\ValueNotFound;
use Comode\graph\store\value\IFactory as IValueFactory;

class Store implements IStore
{
    private $nodeRoot;
    private $valueIndex;
    private $id;
    private $valueFactory;
 
    public function __construct(
        IDirectory $nodeRoot,
        IDirectory $valueIndex,
        IId $id,
        IValueFactory $valueFactory
    ) {
        $this->nodeRoot = $nodeRoot;
        $this->valueIndex = $valueIndex;
        $this->id = $id;
        $this->valueFactory = $valueFactory;
    }
    
    public function create()
    {
        $nodeId = $this->id->next();

        $this->nodeRoot->directory($nodeId)->create();

        return $nodeId;
    }
    
    public function directory($nodeId)
    {
        return $this->nodeRoot->directory($nodeId);
    }
    
    public function bindValue($nodeId, IDirectory $valueDirectory)
    {
        $this->valueIndex
            ->directory($nodeId)
            ->link($valueDirectory->name())
            ->create($valueDirectory->path());
    }
    
    public function getValue($nodeId)
    {
        $nodeIndexDirectory = $this->nodeRoot->directory($nodeId);

        $links = $nodeIndexDirectory->links();

        if (empty($links)) {
            throw new ValueNotFound();
        }

        $valueDirectory = $links[0]->directory();

        $valueFiles = $valueDirectory->files();

        $valueFile = $valueFiles[0];

        if ($valueFile->name() == $valueDirectory->name()) {
            return $this->valueFactory->makeString($valueFile->read());
        } else {
            return $this->valueFactory->makeFile($valueFile->path());
        }
    }
}