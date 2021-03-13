<?php

namespace Botble\News\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\News\Repositories\Interfaces\NewsInterface;
use Botble\Base\Enums\BaseStatusEnum;

class NewsRepository extends RepositoriesAbstract implements NewsInterface
{
	public function getListNewsNonInList(array $selected = [], $limit = 3)
    {
        $data = $this->model
            ->where('news.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('news.id', $selected)
            ->limit($limit)
            ->orderBy('news.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
