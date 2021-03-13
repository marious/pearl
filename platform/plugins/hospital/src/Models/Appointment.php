<?php
namespace Botble\Hospital\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends BaseModel
{
    use SoftDeletes;

    protected $table = 'hs_appointments';

    protected $fillable = [
        'patient_name',
        'patient_phone',
        'patient_email',
        'appointment_date',
        'message',
        'department_id',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id')->withDefault();
    }
}
