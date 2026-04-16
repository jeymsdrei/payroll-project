<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\Deduction;
use App\Models\User;
use App\Services\PayrollCalculator;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
            'salary_base' => 0,
            'hourly_rate' => 0,
            'overtime_rate' => 0,
            'tax_rate' => 0.15,
        ]);

        $employee = User::factory()->create([
            'name' => 'Jane Employee',
            'email' => 'jane@example.com',
            'role' => User::ROLE_EMPLOYEE,
            'salary_base' => 4200,
            'hourly_rate' => 30,
            'overtime_rate' => 45,
            'tax_rate' => 0.16,
        ]);

        $employee->attendanceRecords()->createMany([
            ['recorded_at' => Carbon::now()->subDays(7)->toDateString(), 'hours_worked' => 8, 'overtime_hours' => 1.5, 'status' => 'present'],
            ['recorded_at' => Carbon::now()->subDays(6)->toDateString(), 'hours_worked' => 8, 'overtime_hours' => 2, 'status' => 'present'],
            ['recorded_at' => Carbon::now()->subDays(5)->toDateString(), 'hours_worked' => 7.5, 'overtime_hours' => 0, 'status' => 'present'],
        ]);

        Benefit::create(['user_id' => $employee->id, 'description' => 'Performance bonus', 'amount' => 250, 'effective_from' => Carbon::now()->subMonth()->toDateString()]);
        Deduction::create(['user_id' => $employee->id, 'description' => 'Health insurance', 'amount' => 120, 'effective_from' => Carbon::now()->subMonth()->toDateString()]);

        app(PayrollCalculator::class)->createPayroll($employee, Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
    }
}
