<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'school_name',
        'tefa_name',
        'department_name',

        'address',
        'phone',
        'email',
        'website',

        'school_logo',
        'tefa_logo',

        'head_program_id',
        'treasurer_id',
    ];

    public function headProgram(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_program_id');
    }

    public function treasurer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'treasurer_id');
    }
}