<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'period_start',
        'period_end',
        'total_hours',
        'overtime_hours',
        'gross_pay',
        'tax_amount',
        'deductions_amount',
        'benefits_amount',
        'net_pay',
        'details',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'gross_pay' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'deductions_amount' => 'decimal:2',
        'benefits_amount' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
