<?php

namespace Botble\Hospital\Repositories\Caches;

use Botble\Hospital\Repositories\Interfaces\DoctorInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class DoctorCacheDecorator extends CacheAbstractDecorator implements DoctorInterface
{
    public function getFeatured(int $limit = 5, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }


    public function getByDepartment($departmentId, $paginate = 12, $limit = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getSearch($query, $limit = 10, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getAllDoctors($perPage = 12, $active = true, array $with = ['slugable'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
