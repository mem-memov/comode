<?php
namespace service\router\part;
interface IPart {
  
    public function run();
    public function setAction(
        \service\router\action\IAction $action
    );
  
}