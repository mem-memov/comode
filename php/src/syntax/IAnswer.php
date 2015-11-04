<?php
namespace Comode\syntax;

interface IAnswer
{
    public function getId();
    public function addCompliment(node\ICompliment $complimentNode);
    public function getValue();
    public function isFile();
}