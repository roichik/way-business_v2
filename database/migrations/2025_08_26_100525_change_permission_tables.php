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
        Schema::table('admin_permissions', function (Blueprint $table) {
            $table->string('description', 1000)->nullable()->after('guard_name');
        });
        Schema::table('admin_roles', function (Blueprint $table) {
            $table->string('description', 1000)->nullable()->after('guard_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('admin_permissions', 'description');
        Schema::dropColumns('admin_roles', 'description');
    }
};
