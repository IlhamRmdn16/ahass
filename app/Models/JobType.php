<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function unitEntries(): HasMany
    {
        return $this->hasMany(UnitEntry::class);
    }
}
