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
        Schema::create('service_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('caregiver_id')->constrained('caregivers')->onDelete('cascade');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');

            //value in money
            $table->decimal('service_price', 10, 2)->nullable();
            $table->decimal('price_per_hour', 10,2)->nullable();
            $table->decimal('caregiver_payout_per_hour', 10, 2)->nullable(); //caregiver payout
            $table->decimal('mileage_amount', 10, 2)->nullable(); //caregiver mileage reimbursement
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_jobs');
    }
};
