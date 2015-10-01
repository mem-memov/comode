<?php
namespace WebApi\router\part;
interface IPart {
  
    public function run();
    public function setAction(
        \WebApi\router\action\IAction $action
    );
  
}