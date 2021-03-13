<?php

namespace Botble\Hospital\Repositories\Caches;

use Botble\Hospital\Repositories\Interfaces\DepartmentInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class DepartmentCacheDecorator extends CacheAbstractDecorator implements DepartmentInterface
{
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());

    }

    public function getAllDepartments(array $condition = [], array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getDepartmentById($id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getDepartments(array $select, array $orderBy)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getAllRelatedChildrenIds($id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getAllDepartmentsWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getFilters($filters)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getPopularDepartments(int $limit)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getDepartmentsFroFront(int $limit)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getFeaturedDepartments($limit, array $with = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function get_departments_id()
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getPaginatedDepartments($params = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
