<?php
namespace WebApi\router\part;
interface IFactory {
  
    public function make(array $partNames, array $data);
  
}