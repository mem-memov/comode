<?php
namespace WebApi\router\action\controller\response;
interface IFactory {
    
    public function html($html);
    public function json(array $data);
    
}