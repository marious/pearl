<?php

namespace Botble\News\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\News\Repositories\Interfaces\NewsInterface;

class NewsCacheDecorator extends CacheAbstractDecorator implements NewsInterface
{
	public function getListNewsNonInList(array $selected = [], $limit = 3)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
