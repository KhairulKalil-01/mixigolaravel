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
        Schema::create('staff_overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade');
            $table->date('overtime_date');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->decimal('hours', 5, 2);
            $table->decimal('rate', 8, 2);
            $table->decimal('amount', 10, 2);
            $table->integer('status')->default(0); // 0 = Pending, 1 = Approved, 2 = Rejected, 3 = Paid/Completed
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_overtimes');
    }
};
