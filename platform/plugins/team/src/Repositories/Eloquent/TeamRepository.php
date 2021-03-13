<?php

namespace Botble\Team\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\Team\Repositories\Interfaces\TeamInterface;
use Botble\Base\Enums\BaseStatusEnum;

class TeamRepository extends RepositoriesAbstract implements TeamInterface
{
    public function getListMemberNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('teams.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('teams.id', $selected)
            ->limit($limit)
            ->orderBy('teams.created_at', 'asc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
