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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('branch_id')->nullable(); // Foreign key to branches table

            $table->string('name');
            $table->string('ic_num')->nullable();
            $table->integer('age')->nullable();
            $table->string('sex')->nullable();
            $table->float('weight')->nullable();
            $table->text('condition_description')->nullable();
            $table->string('caregiver_service')->nullable(); // Could be a string like 'Required'/'Not Required'
            $table->string('physiotherapy')->nullable();     // Could be a string like 'Required'/'Not Required'
            $table->text('nursing_procedures')->nullable();  // Store as comma-separated
        
            $table->string('mobileno')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->boolean('is_active')->default(true); // 1=active, 0=inactive
        
            // Foreign key constraint (optional at this stage if branches table not yet created)
            //$table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
