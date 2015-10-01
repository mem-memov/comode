<?php
namespace WebApi\router\part;
interface IPart {
  
    public function run();
    public function setAction(
        \service\router\action\IAction $action
    );
  
}