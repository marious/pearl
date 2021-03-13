<?php

namespace Botble\Team\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface TeamInterface extends RepositoryInterface
{
	public function getListMemberNonInList(array $selected = [], $limit = 3);
}
