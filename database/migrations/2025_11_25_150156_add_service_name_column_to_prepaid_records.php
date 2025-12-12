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
        Schema::table('prepaid_records', function (Blueprint $table) {
            $table->unsignedBigInteger('quotation_item_id')->nullable()->after('invoice_id');
            $table->foreign('quotation_item_id')->references('id')->on('quotation_items');
            $table->string('service_name')->nullable()->after('quotation_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prepaid_records', function (Blueprint $table) {
            $table->dropColumn('service_name');
            $table->dropForeign(['quotation_item_id']);
            $table->dropColumn('quotation_item_id');
        });
    }
};
