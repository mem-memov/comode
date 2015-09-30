<?php
namespace Comode;

interface IFileSystem
{
	public function makeDirectory($id = null);
	public function addLink($fromId, $toId);
}