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
        Schema::create('caregivers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('sex')->nullable();
            $table->string('name');
            $table->string('ic_num')->nullable();
            $table->string('passport')->nullable();
            $table->string('email')->unique();
            $table->string('mobileno')->nullable();
            $table->unsignedBigInteger('bank_list_id')->nullable();
            $table->string('bank_num')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_available')->default(true); // 1 = available, 0 = not available
            $table->boolean('is_active')->default(true); // 1 = active, 0 = inactive
            $table->boolean('employment_type')->default(false); // 0 = part time, 1 = full time
            $table->string('qualification')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone_no')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caregivers');
    }
};
