<?php

namespace Botble\Service\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Service\Repositories\Interfaces\BusinessSolutionsInterface;

class BusinessSolutionsCacheDecorator extends CacheAbstractDecorator implements BusinessSolutionsInterface
{
	public function getListBusinessSolutionsNonInList(array $selected = [], $limit = 6)
    {
    	return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
    public function getFirstById($id){
    	return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
