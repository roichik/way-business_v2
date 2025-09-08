<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable(false)->after('user_id');
            $table->unsignedBigInteger('division_id')->after('company_id');
            $table->unsignedBigInteger('position_id')->after('division_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_detail', function (Blueprint $table) {
            $table->dropColumn(['company_id', 'division_id', 'position_id']);
        });
    }
};
