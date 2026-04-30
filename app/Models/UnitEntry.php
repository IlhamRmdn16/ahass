<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry_date',
        'entry_time',
        'police_number',
        'motor_type',
        'mechanic_id',
        'job_type_id',
        'phone_number',
        'is_daya_auto',
        'reason',
    ];

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function jobType(): BelongsTo
    {
        return $this->belongsTo(JobType::class);
    }
}
