<?php

namespace Botble\Counter\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Counter extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'counters';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'key',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function counters()
    {
        return $this->hasMany(CounterItem::class, 'counter_id')->orderBy('order', 'ASC');
    }
}
