<?php
namespace Comode\graph\store\value;

class String implements IString
{
    private $content;
    
    public function __construct($content)
    {
        $this->content = $content;
    }

    public function structure()
    {
        return [
            'type' => 'string',
            'content' => $this->content
        ];
    }
    
    public function getContent()
    {
        return $this->content;
    }
}