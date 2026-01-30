<?php

namespace Kiwi\Core\Admin\Model;


trait SoftDelete
{
	protected function deleteKey()
	{
		return "state";
	}

	protected function deleteState()
	{
		return self::STATE_DELETED;
	}

	protected function performDeleteOnModel()
	{
		$query = $this->setKeysForSaveQuery($this->newModelQuery());
		$columns = [self::deleteKey() => self::deleteState(),];
		$query->update($columns);
		$this->syncOriginalAttributes(array_keys($columns));
	}
}
