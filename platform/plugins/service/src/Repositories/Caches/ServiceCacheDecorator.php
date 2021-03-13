<?php

namespace Botble\Service\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Service\Repositories\Interfaces\ServiceInterface;

class ServiceCacheDecorator extends CacheAbstractDecorator implements ServiceInterface
{
	public function getAllServices($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
    public function getListServiceNonInList(array $selected = [], $limit = 6)
    {
    	return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
