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
        Schema::create('staff_salary_advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->integer('status')->default(0); // 0 = Pending, 1 = Approved, 2 = Rejected, 3 = Paid/Completed
            $table->boolean('deducted')->default(false); // true once deducted in payroll
            $table->unsignedInteger('payroll_id')->nullable();
            $table->text('request_reason')->nullable();
            $table->text('approval_remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_salary_advances');
    }
};
