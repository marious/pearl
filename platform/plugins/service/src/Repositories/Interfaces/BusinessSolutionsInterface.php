<?php

namespace Botble\Service\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface BusinessSolutionsInterface extends RepositoryInterface
{
    public function getListBusinessSolutionsNonInList(array $selected = [], $limit = 7);
    public function getFirstById($id);
}
