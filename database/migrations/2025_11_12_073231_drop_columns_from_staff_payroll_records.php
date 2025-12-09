<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('staff_payroll_records', function (Blueprint $table) {
            $table->dropColumn(['overtime_total', 'allowances_total', 'claims_total', 'deductions_total', 'net_salary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_payroll_records', function (Blueprint $table) {
            $table->decimal('overtime_total', 15, 2)->default(0);
            $table->decimal('allowances_total', 15, 2)->default(0);
            $table->decimal('claims_total', 15, 2)->default(0);
            $table->decimal('deductions_total', 15, 2)->default(0);
            $table->decimal('net_salary', 15, 2)->default(0);
        });
    }
};
