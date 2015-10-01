<?php
namespace service\router\request;
interface IRequest {
    
    public function hasPost($parameter);
    public function post($parameter);
    public function hasGet($parameter);
    public function get($parameter);
    public function isCommandLine();
    public function command();
    public function arguments();
    
}