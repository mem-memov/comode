<?php
namespace Comode;

interface IFileSystem
{
	public function makeDirectory();
	public function addLink($fromId, $toId);
}