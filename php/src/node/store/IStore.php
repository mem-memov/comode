<?php
namespace Comode\node\store;

use Comode\node\value\IValue;

interface IStore
{
	public function idExists($id);
	public function createId(IValue $value = null);
	public function linkIds($fromId, $toId);
        public function getChildIds($id);
}