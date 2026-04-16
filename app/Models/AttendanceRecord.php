<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recorded_at',
        'hours_worked',
        'overtime_hours',
        'status',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'date',
        'hours_worked' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
