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
        Schema::table('caregivers', function (Blueprint $table) {
            //Drop column
            $table->dropColumn(['address']);

            // Add column
            $table->string('nationality')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_state')->nullable();

            // change to column attribute
            $table->string('email')->nullable()->change();
            $table->tinyInteger('employment_type')->default(2)->change(); // Part time
        });
    }


    public function down(): void
    {
        Schema::table('caregivers', function (Blueprint $table) {
            $table->string('address')->nullable();

            
            $table->dropColumn(['nationality', 'current_city', 'current_state']);

            $table->string('email')->nullable(false)->change();
            $table->tinyInteger('employment_type')->default(0)->change(); // Replace 0 with previous default if different
        });
    }
};
