<?php
namespace Botble\Counter\Models;

use Botble\Base\Models\BaseModel;

class CounterItem extends BaseModel
{
    protected $table = 'counter_items';

    protected $fillable = [
        'name',
        'order',
        'count',
        'counter_id',
    ];
}
