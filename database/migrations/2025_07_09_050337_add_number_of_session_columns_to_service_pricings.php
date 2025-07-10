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
        Schema::table('service_pricings', function (Blueprint $table) {
            $table->integer('number_of_sessions')->nullable()->after('number_of_hours');
            $table->decimal('price', 10, 2)->change()->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_pricings', function (Blueprint $table) {
            //
        });
    }
};
