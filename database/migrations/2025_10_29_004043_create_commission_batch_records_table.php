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
        Schema::create('commission_batch_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commission_batch_id')->constrained('commission_batches')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('staffs')->nullOnDelete();
            $table->foreignId('external_agent_id')->nullable()->constrained('external_agents')->nullOnDelete();
            $table->foreignId('commission_claim_id')->constrained('commission_claims')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_batch_records');
    }
};
