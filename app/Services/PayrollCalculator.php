<?php

namespace App\Services;

use App\Models\Benefit;
use App\Models\Deduction;
use App\Models\Payroll;
use App\Models\User;
use Carbon\Carbon;

class PayrollCalculator
{
    public function calculate(User $user, Carbon $periodStart, Carbon $periodEnd): array
    {
        $attendance = $user->attendanceRecords()
            ->whereBetween('recorded_at', [$periodStart->toDateString(), $periodEnd->toDateString()])
            ->get();

        $benefits = $user->benefits()
            ->where('effective_from', '<=', $periodEnd->toDateString())
            ->sum('amount');

        $deductions = $user->deductions()
            ->where('effective_from', '<=', $periodEnd->toDateString())
            ->sum('amount');

        $totalHours = $attendance->sum('hours_worked');
        $overtimeHours = $attendance->sum('overtime_hours');

        $baseSalary = $user->salary_base ?: 0;
        $hourlyPay = ($user->hourly_rate ?: 0) * $totalHours;
        $overtimePay = ($user->overtime_rate ?: 0) * $overtimeHours;
        $grossPay = $baseSalary + $hourlyPay + $overtimePay + $benefits;
        $taxRate = $user->tax_rate ?: 0.15;
        $taxAmount = round($grossPay * $taxRate, 2);
        $netPay = round($grossPay - $taxAmount - $deductions, 2);

        return [
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),
            'total_hours' => $totalHours,
            'overtime_hours' => $overtimeHours,
            'gross_pay' => round($grossPay, 2),
            'benefits_amount' => round($benefits, 2),
            'deductions_amount' => round($deductions, 2),
            'tax_amount' => $taxAmount,
            'net_pay' => max($netPay, 0),
            'details' => [
                'base_salary' => round($baseSalary, 2),
                'hourly_pay' => round($hourlyPay, 2),
                'overtime_pay' => round($overtimePay, 2),
                'tax_rate' => $taxRate,
                'benefit_count' => $user->benefits()->count(),
                'deduction_count' => $user->deductions()->count(),
            ],
        ];
    }

    public function createPayroll(User $user, Carbon $periodStart, Carbon $periodEnd): Payroll
    {
        $payload = $this->calculate($user, $periodStart, $periodEnd);

        return Payroll::create([
            'user_id' => $user->id,
            'period_start' => $payload['period_start'],
            'period_end' => $payload['period_end'],
            'total_hours' => $payload['total_hours'],
            'overtime_hours' => $payload['overtime_hours'],
            'gross_pay' => $payload['gross_pay'],
            'tax_amount' => $payload['tax_amount'],
            'deductions_amount' => $payload['deductions_amount'],
            'benefits_amount' => $payload['benefits_amount'],
            'net_pay' => $payload['net_pay'],
            'details' => $payload['details'],
        ]);
    }
}
