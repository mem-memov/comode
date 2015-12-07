<?php
namespace Comode\graph\store\value;

class File implements IFile
{
    private $structure;
    
    public function __construct($path)
    {
        $this->structure = [
            'type' => 'file',
            'path' => $path
        ];
    }

    public function structure()
    {
        return $this->structure;
    }
    
    public function getPath()
    {
        return $this->path;
    }
}
