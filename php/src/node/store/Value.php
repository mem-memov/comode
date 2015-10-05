<?php
namespace Comode\node\store;

class Value implements IValue
{
    private $isFile;
    private $content;
    
    public function __construct($isFile, $content)
    {
        $this->isFile = $isFile;
        $this->content = $content;
    }
    
    public function isFile()
    {
        return $this->isFile;
    }
    
    public function getContent()
    {
        return $this->content;
    }
}
