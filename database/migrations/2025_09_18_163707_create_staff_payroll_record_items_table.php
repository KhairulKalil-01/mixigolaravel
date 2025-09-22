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
        Schema::create('staff_payroll_record_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_payroll_record_id')->constrained('staff_payroll_records')->onDelete('cascade'); 
            $table->integer('type'); // 1-earning, 2-deduction
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_payroll_record_items');
    }
};
