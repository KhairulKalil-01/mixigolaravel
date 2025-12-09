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
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();

            $table->string('credit_note_number')->unique();
            $table->foreignId('invoice_id')->constrained('invoices');
            $table->foreignId('client_id')->constrained('clients');
            $table->date('credit_note_date');
            $table->decimal('credit_amount', 10, 2);
            $table->integer('reason_type')->nullable(); //( 1: Cancellation, 2: Discount adjustment)
            $table->string('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_notes');
    }
};
