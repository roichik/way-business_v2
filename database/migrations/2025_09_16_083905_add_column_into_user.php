<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
        });

        DB::table('user_types')->insert([
            ['title' => 'Сотрудник'],
            ['title' => 'Кандидат'],
        ]);

        Schema::table('user_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable(true)->after('user_id');
        });

        DB::table('user_detail')->update([
            'type_id' => 1,
        ]);

        Schema::table('user_detail', function (Blueprint $table) {
            $table
                ->foreign('type_id')
                ->on('user_types')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->json('flags')->nullable(true)->after('is_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_detail', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('flags');
        });
        Schema::dropIfExists('user_types');
    }
};
