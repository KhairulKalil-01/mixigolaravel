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
        Schema::table('client_payments', function (Blueprint $table) {
            //change column 'quotation_id' to 'invoice_id'
            // change payment_type to 'integer and set default value to 0
            // change payment_status to 'integer and set default value to 0
            // change payment_method to 'integer and set default value to 0
            // $table->integer('payment_type')->default(0)->change();
            // $table->integer('payment_status')->default(0)->change();
            // $table->integer('payment_method')->default(0)->change();
            $table->dropColumn('payment_type');
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_status');
            $table->rename('quotation_id', 'invoice_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_payments', function (Blueprint $table) {
            //
        });
    }
};
