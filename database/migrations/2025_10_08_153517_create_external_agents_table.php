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
        Schema::create('external_agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('ic_no')->nullable();
            $table->string('email')->nullable();
            $table->string('mobileno')->nullable();
            $table->string('tax_no')->nullable(); // tax identification number
            $table->foreignId('bank_id')->nullable()->constrained('bank_lists')->nullOnDelete()->after('passport');
            $table->string('bank_acc_no')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_agents');
    }
};
