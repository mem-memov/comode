<?php
namespace Comode\syntax;

class FileAnswer implements IAnswer
{
    public function isFile() {
        return true;
    }
}