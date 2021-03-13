<?php
namespace Botble\Hospital\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Eloquent;

class DepartmentRepository extends RepositoriesAbstract implements DepartmentInterface
{

    public function getDataSiteMap()
    {
        $data = $this->model
                    ->with('slugable')
                    ->where('hs_departments.status', BaseStatusEnum::PUBLISHED)
                    ->select('hs_departments.*')
                    ->orderBy('hs_departments.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }


    public function getAllDepartments(array $condition = [], array $with = [])
    {
        $data = $this->model->with('slugable')->select('hs_departments.*');
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->orderBy('hs_departments.created_at', 'desc')
                ->orderBy('hs_departments.order', 'desc');

        if ($with) {
            $data = $data->with($with);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }


    public function getDepartmentById($id)
    {
        $data = $this->model->with('slugable')->where([
            'hs_departments.id'     => $id,
            'hs_departments.status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeExecuteQuery($data, true)->first();
    }


    public function getDepartments(array $select, array $orderBy)
    {
        $data = $this->model->with('slugable')->select($select);
        foreach ($orderBy as $by => $direction) {
            $data = $data->orderBy($by, $direction);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getPaginatedDepartments($params = [])
    {
        $this->model = $this->originalModel;

        $orderBy = isset($params['order_by']) ? $params['order_by'] : 'created_at';
        $order = isset($params['order']) ? $params['order'] : 'desc';
        $this->model->where('status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$params['paginate']['per_page']);
    }

    public function getAllRelatedChildrenIds($id)
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['hs_departments.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('hs_departments.id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIds($child), $result);
        }
        $this->resetModel();

        return array_unique($result);
    }

    public function getAllDepartmentsWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        $data = $this->model
            ->where($condition)
            ->with($with)
            ->select($select);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getFilters($filters)
    {
        $this->model = $this->originalModel;

        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'created_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';
        $this->model->where('status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }

    public function getPopularDepartments(int $limit)
    {
        $data = $this->model
            ->with('slugable')
            ->withCount('doctors')
            ->orderBy('doctors_count', 'desc')
            ->where('hs_departments.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getDepartmentsFroFront(int $limit)
    {
        $data = $this->getFeaturedDepartments($limit);
        $data2 = [];
        if (count($data) < $limit) {
            $limit = $limit - count($data);
            $data2 = $this->model
                            ->with(['slugable'])
                            ->where([
                                'hs_departments.status' => BaseStatusEnum::PUBLISHED,
                                'hs_departments.parent_id' => 0,
                            ])
                            ->orderBy('hs_departments.order', 'asc')
                            ->select('hs_departments.*')
                            ->limit($limit)
                            ->get();
        }



        return $data->merge($data2);
    }

    public function getFeaturedDepartments($limit, array $with = [])
    {
        $data = $this->model
                    ->with(array_merge(['slugable'], $with))
                    ->where([
                        'hs_departments.status' => BaseStatusEnum::PUBLISHED,
                        'hs_departments.is_featured' => 1,
                    ])
                    ->orderBy('hs_departments.order', 'asc')
                    ->select('hs_departments.*')
                    ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function get_departments_id()
    {
        $data = $this->model->pluck('id');
        return $data->toArray();
    }
}
