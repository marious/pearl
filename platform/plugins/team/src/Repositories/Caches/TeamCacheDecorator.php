<?php

namespace Botble\Team\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Team\Repositories\Interfaces\TeamInterface;

class TeamCacheDecorator extends CacheAbstractDecorator implements TeamInterface
{
    public function getListMemberNonInList(array $selected = [], $limit = 12)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
