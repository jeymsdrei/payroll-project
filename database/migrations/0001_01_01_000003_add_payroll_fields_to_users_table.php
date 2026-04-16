<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee')->after('password');
            $table->decimal('salary_base', 12, 2)->default(0)->after('role');
            $table->decimal('hourly_rate', 10, 2)->default(0)->after('salary_base');
            $table->decimal('overtime_rate', 10, 2)->default(0)->after('hourly_rate');
            $table->decimal('tax_rate', 5, 4)->default(0.15)->after('overtime_rate');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'salary_base', 'hourly_rate', 'overtime_rate', 'tax_rate']);
        });
    }
};
