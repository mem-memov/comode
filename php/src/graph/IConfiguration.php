<?php
namespace Comode\graph;

interface IConfiguration
{
    public function makeNodeFactory();
    public function makeValueFactory();
}