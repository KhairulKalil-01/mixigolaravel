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
        Schema::table('service_jobs', function (Blueprint $table) {
            $table->decimal('hours', 8, 2)->after('end_datetime');
            $table->decimal('caregiver_payout_total', 10, 2)->after('mileage_amount');
            $table->string('status')->after('caregiver_payout_total');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_jobs', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['hours', 'caregiver_payout_total', 'status', 'created_by']);
        });
    }
};