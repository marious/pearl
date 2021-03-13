<?php

namespace Botble\Service\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\Service\Repositories\Interfaces\BusinessSolutionsInterface;

class BusinessSolutionsRepository extends RepositoriesAbstract implements BusinessSolutionsInterface
{
	public function getListBusinessSolutionsNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('business_solutions.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('business_solutions.id', $selected)
            ->limit($limit)
            ->orderBy('business_solutions.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }
    public function getFirstById($id){
    	$data = $this->model->with('slugable')->where([
            'business_solutions.id'     => $id,
            'business_solutions.status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeExecuteQuery($data, true)->first();
    }
}
