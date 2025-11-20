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
        Schema::create('prepaid_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prepaid_record_id')->constrained('prepaid_records')->onDelete('cascade');
            $table->unsignedBigInteger('service_job_id')->nullable();
            $table->decimal('actual_hour', 8, 2);
            $table->decimal('multiplier', 5, 2)->default(1);
            $table->decimal('deducted_hour', 8, 2);
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prepaid_deductions');
    }
};
