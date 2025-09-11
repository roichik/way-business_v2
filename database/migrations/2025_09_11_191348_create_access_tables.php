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
        Schema::create('access_addons', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->json('flags')->nullable(true);

            $table
                ->foreign('user_id', 'access_companies_user_fk')
                ->on('users')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });

        Schema::create('access_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('company_id')->nullable(false);

            $table
                ->foreign('user_id', 'access_companies_user_fk2')
                ->on('users')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreign('company_id', 'access_companies_company_fk2')
                ->on('companies')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_addons');
        Schema::dropIfExists('access_companies');
    }
};
