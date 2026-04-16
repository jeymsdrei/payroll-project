<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'effective_from',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'effective_from' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
