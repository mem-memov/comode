<?php
namespace Comode\graph\store\value;

use Comode\graph\store\exception\ValueTypeUnknown;

class Factory implements IFactory
{
    public function makeString($content)
    {
        return new String($content);
    }
    
    public function makeFile($path)
    {
        return new File($path);
    }
    
    public function make(array $structure, array $decorators = [])
    {
        switch ($structure['type']) {
            case 'string':
                $value = $this->createString($structure['content']);
                foreach ($decorators as $decorator) {
                    $value = $this->decorateString($value, $decorator);
                }
                break;
            case 'file':
                $value = $this->createFile($structure['file']);
                foreach ($decorators as $decorator) {
                    $value = $this->decorateFile($value, $decorator);
                }
                break;
            default:
                throw new ValueTypeUnknown($structure['type']);
        }
        
        return $value;
    }
    
    private function decorateString(IString $value, IDecorator $decorator) {
        return $decorator->makeString($value);
    }
    
    private function decorateFile(IFile $value, IDecorator $decorator) {
        return $decorator->makeFile($value);
    }
}