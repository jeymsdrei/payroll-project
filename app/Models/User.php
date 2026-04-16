<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\AttendanceRecord;
use App\Models\Benefit;
use App\Models\Deduction;
use App\Models\Payroll;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public const ROLE_ADMIN = 'admin';
    public const ROLE_EMPLOYEE = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'salary_base',
        'hourly_rate',
        'overtime_rate',
        'tax_rate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'salary_base' => 'decimal:2',
            'hourly_rate' => 'decimal:2',
            'overtime_rate' => 'decimal:2',
            'tax_rate' => 'decimal:4',
        ];
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }
}

