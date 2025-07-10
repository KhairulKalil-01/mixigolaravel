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
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_pricing_id')->constrained()->onDelete('cascade');

            $table->string('service_name');              // Snapshot of service name
            $table->decimal('unit_price', 10, 2);        // Price per unit at quotation time
            $table->integer('quantity')->default(1);     // How many units
            $table->decimal('subtotal', 10, 2);          // unit_price × quantity
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
