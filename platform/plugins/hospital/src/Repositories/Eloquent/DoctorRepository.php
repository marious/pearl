<?php
namespace Botble\Hospital\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Hospital\Repositories\Interfaces\DoctorInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class DoctorRepository extends RepositoriesAbstract implements DoctorInterface
{
    public function getFeatured(int $limit = 4, $with = [])
    {
        $data = $this->model
                  ->where([
                    'hs_doctors.status'   => BaseStatusEnum::PUBLISHED,
                    'hs_doctors.is_featured'  => 1,
                  ])
                  ->limit($limit)
                  ->with(array_merge(['slugable'], $with))
                  ->orderBy('hs_doctors.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getByDepartment($departmentId, $paginate = 12, $limit = 0)
    {
        if (!is_array($departmentId)) {
            $departmentId = [$departmentId];
        }

        $data = $this->model
            ->where('hs_doctors.status', BaseStatusEnum::PUBLISHED)
            ->join('hs_doctor_departments', 'hs_doctor_departments.doctor_id', '=', 'hs_doctors.id')
            ->join('hs_departments', 'hs_doctor_departments.department_id', '=', 'hs_departments.id')
            ->whereIn('hs_doctor_departments.department_id', $departmentId)
            ->select('hs_doctors.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('hs_doctors.created_at', 'desc');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('hs_doctors.status', BaseStatusEnum::PUBLISHED)
            ->select('hs_doctors.*')
            ->orderBy('hs_doctors.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }


    public function getSearch($query, $limit = 10, $paginate = 10)
    {
        $data = $this->model->with('slugable')->where('hs_doctors.status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $data = $data->where('hs_doctors.name', 'LIKE', '%' . $term . '%');
        }

        $data = $data->select('hs_doctors.*')
            ->orderBy('hs_doctors.created_at', 'desc');

        if ($limit) {
            $data = $data->limit($limit);
        }

        if ($paginate) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getAllDoctors($perPage = 12, $active = true, array $with = [])
    {
        $data = $this->model->select('hs_doctors.*')
            ->with(array_merge(['slugable'], $with))
            ->orderBy('hs_doctors.created_at', 'desc');

        if ($active) {
            $data = $data->where('hs_doctors.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

}
