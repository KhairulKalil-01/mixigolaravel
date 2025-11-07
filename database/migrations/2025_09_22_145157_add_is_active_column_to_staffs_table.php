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
        Schema::table('staffs', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('id');
            $table->string('income_tax_no')->nullable()->after('is_active');
            $table->string('epf_no')->nullable()->after('income_tax_no');
            $table->string('socso_no')->nullable()->after('epf_no');
            $table->foreignId('bank_id')->nullable()->constrained('bank_lists')->nullOnDelete()->after('passport');
            $table->string('bank_acc_no')->nullable()->after('bank_id')->after('bank_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staffs', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);

            $table->dropColumn([
                'is_active',
                'income_tax_no',
                'epf_no',
                'socso_no',
                'bank_id',
                'bank_acc_no',
            ]);
        });
    }
};
