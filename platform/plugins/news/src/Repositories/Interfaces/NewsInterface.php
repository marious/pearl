<?php

namespace Botble\News\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface NewsInterface extends RepositoryInterface
{
	public function getListNewsNonInList(array $selected = [], $limit = 3);
}
