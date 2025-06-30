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
        Schema::table('client_patient_relationship', function (Blueprint $table) {
            $table->string('relation_to_client')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_patient_relationship', function (Blueprint $table) {
            $table->string('relation_to_client')->nullable(false)->change();
        });
    }
};
