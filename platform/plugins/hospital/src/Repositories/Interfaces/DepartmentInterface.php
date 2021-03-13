<?php

namespace Botble\Hospital\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface DepartmentInterface extends RepositoryInterface
{
    public function getDataSiteMap();

    public function getAllDepartments(array $condition = [], array $with = []);

    public function getDepartmentById($id);

    public function getDepartments(array $select, array $orderBy);

    public function getAllRelatedChildrenIds($id);

    public function getAllDepartmentsWithChildren(array $condition = [], array $with = [], array $select = ['*']);

    public function getFilters($filters);

    public function getPopularDepartments(int $limit);

    public function getDepartmentsFroFront(int $limit);

    public function getFeaturedDepartments($limit, array $with = []);

    public function get_departments_id();

    public function getPaginatedDepartments($params = []);

}
