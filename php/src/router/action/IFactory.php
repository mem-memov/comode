<?php
namespace WebApi\router\action;

interface IFactory
{
    public function controller(array $data);
}
