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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->string('quotation_number');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->date('service_start_date')->nullable();
            $table->string('caregiver_service');
            $table->integer('caregiver_qty')->nullable();
            $table->decimal('caregiver_price', 10, 2)->nullable();
            $table->decimal('nursing_price', 10, 2)->nullable();
            $table->integer('physiotherapy_qty')->nullable();
            $table->decimal('physiotherapy_price', 10, 2)->nullable();
            $table->decimal('subtotal_price', 10, 2)->nullable();
            $table->decimal('adjustment_price', 10, 2)->nullable();
            $table->decimal('mileage', 10, 2)->nullable();
            $table->decimal('wound_adjustment', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->date('valid_until')->nullable();
            $table->integer('status')->default(0); //	0-pending, 1-Proceed, 2-paid(deposit), 3-cancel, 4-Delivered (Invoice Created)
            $table->boolean('job_created')->default(false); // 0=not created, 1=job created 

            $table->integer('tracheostomy_care')->nullable();
            $table->integer('stoma_care')->nullable();
            $table->integer('peg_tube_care')->nullable();
            $table->integer('bedsore_care')->nullable();
            $table->integer('wound_care')->nullable();
            $table->integer('food_tube_insertion')->nullable();
            $table->integer('urine_cartheter')->nullable();
            $table->integer('iv_drip_infusion')->nullable();
            $table->integer('suction')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
