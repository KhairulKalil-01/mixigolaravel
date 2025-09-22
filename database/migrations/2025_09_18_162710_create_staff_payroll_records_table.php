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
        Schema::create('staff_payroll_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_payroll_batch_id')->constrained('staff_payroll_batches')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staffs')->onDelete('cascade');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('overtime_total', 10, 2)->default(0);
            $table->decimal('allowances_total', 10, 2)->default(0);
            $table->decimal('claims_total', 10, 2)->default(0);
            $table->decimal('deductions_total', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2);
            $table->integer('status')->default('0'); // 0 - Pending, 1 - Approved, 2 - Paid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_payroll_records');
    }
};
