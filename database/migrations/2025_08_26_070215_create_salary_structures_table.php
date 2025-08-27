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
        Schema::create('salary_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staffs')->onDelete('cascade');
            $table->decimal('base_salary', 10, 2);
            $table->decimal('epf_employee', 5, 2)->default(11.00);
            $table->decimal('epf_employer', 5, 2)->default(13.00);
            $table->decimal('socso_employee', 5, 2)->nullable();
            $table->decimal('socso_employer', 5, 2)->nullable(); 
            $table->decimal('eis_employee', 5, 2)->nullable();
            $table->decimal('eis_employer', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_structures');
    }
};
