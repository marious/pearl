<?php

namespace Botble\Hospital\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface DoctorInterface extends RepositoryInterface
{
    public function getFeatured(int $limit = 5, array $with = []);

    public function getByDepartment($departmentId, $paginate = 12, $limit = 0);

    public function getDataSiteMap();

    public function getSearch($query, $limit = 10, $paginate = 10);

    public function getAllDoctors($perPage = 12, $active = true, array $with = ['slugable']);

    
}
