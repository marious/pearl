<?php

namespace Botble\Hospital\Models;

use Botble\Base\Models\BaseModel;
use Botble\Slug\Traits\SlugTrait;
use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doctor extends BaseModel
{
    use EnumCastable, SlugTrait, SoftDeletes;

    protected $table = 'hs_doctors';

    protected $fillable = [
        'name',
        'status',
        'description',
        'image',
        'phone',
        'mobile',
        'is_featured',
        'author_id',
        'author_type',
    ];


    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'hs_doctor_departments');
    }


    public function author(): MorphTo
    {
        return $this->morphTo();
    }
    

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Doctor $doctor) {
            $doctor->departments()->detach();
        });
    }
}
