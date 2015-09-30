<?php
namespace Comode;

interface IFileSystem
{
	public function directoryExists($id);
	public function makeDirectory();
	public function addLink($fromId, $toId);
}