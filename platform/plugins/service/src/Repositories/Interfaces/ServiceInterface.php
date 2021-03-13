<?php

namespace Botble\Service\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface ServiceInterface extends RepositoryInterface
{
	public function getAllServices($active = true);
	public function getListServiceNonInList(array $selected = [], $limit = 7);
}
