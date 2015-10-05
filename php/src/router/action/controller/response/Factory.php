<?php
namespace WebApi\router\action\controller\response;

class Factory implements IFactory
{
    public function html($html)
    {
        return new Html($html);
    }
    
    public function json(array $data)
    {
        return new Json($data);
    }
}
