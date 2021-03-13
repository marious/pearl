<?php

namespace Botble\Hospital\Models;

use Botble\Base\Models\BaseModel;
use Botble\Slug\Traits\SlugTrait;
use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends BaseModel
{
    use EnumCastable, SlugTrait, SoftDeletes;

    protected $table = 'hs_departments';

    protected $fillable = [
        'name',
        'status',
        'description',
        'image',
        'content',
        'author_id',
        'parent_id',
        'author_type',
        'order',
        'is_featured',
        'is_default',
    ];


    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function doctor(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'hs_doctor_departments')->with('slugable');
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id')->withDefault();
    }

    public function children(): HasMany 
    {
        return $this->hasMany(Department::class, 'parent_id');
    }


    public function appointment(): HasOne
    {
        return $this->hasOne(Appointment::class);
    }

    public static function boot()
    {
        parent::boot();
    }
}
