<?php
namespace service\router\part;
interface IFactory {
  
    public function make(array $partNames, array $data);
  
}