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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->unique();
            $table->string('staff_no')->nullable();

            $table->string('full_name');
            $table->string('ic_num')->nullable();
            $table->string('passport')->nullable();
            $table->string('qualification')->nullable();
            $table->decimal('base_salary', 10, 2)->nullable();
            $table->date('joining_date')->nullable();
            $table->date('birthday')->nullable();

            $table->string('sex')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('address')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();

            $table->string('mobileno')->nullable();
            $table->string('email')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone_no')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
