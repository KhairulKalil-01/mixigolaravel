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
        Schema::table('quotations', function (Blueprint $table) {

            $table->dropColumn([
                'service_start_date',
                'caregiver_service',
                'caregiver_qty',
                'caregiver_price',
                'nursing_price',
                'physiotherapy_qty',
                'physiotherapy_price',
                'wound_adjustment',
                'tracheostomy_care',
                'stoma_care',
                'peg_tube_care',
                'bedsore_care',
                'wound_care',
                'food_tube_insertion',
                'urine_cartheter',
                'iv_drip_infusion',
                'suction',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            //
        });
    }
};
