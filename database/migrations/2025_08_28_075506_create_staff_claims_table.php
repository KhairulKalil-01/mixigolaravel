<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staffs')->onDelete('cascade');
            $table->date('claim_date'); // date of the expense
            $table->string('claim_type'); // travel, meal, medical, etc.
            $table->decimal('amount', 10, 2);
            $table->integer('payment_method')->nullable(); // 1-petty cash, 2-bank transfer, 3-payroll
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->integer('status')->default(0); // 0=pending, 1=approved, 2=rejected, 3=completed
            $table->decimal('approved_amount', 10, 2)->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_claims');
    }
};
