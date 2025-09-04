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
        //Компания, филиалы
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable(true);
            $table->string('title')->nullable(false);
            $table->integer('lft')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('rgt')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('depth')->default(0)->nullable(false)->comment('For sorting');
            $table->timestamps();

            $table
                ->foreign('parent_id', 'companies_company_fk')
                ->on('companies')
                ->references('id')
                ->onUpdate('cascade')
                ->nullOnDelete();
        });

        //Подразделения
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable(true);
            $table->unsignedBigInteger('company_id')->nullable(true);
            $table->string('title')->nullable(false);
            $table->integer('lft')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('rgt')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('depth')->default(0)->nullable(false)->comment('For sorting');
            $table->timestamps();

            $table
                ->foreign('company_id', 'divisions_company_fk')
                ->on('companies')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table
                ->foreign('parent_id', 'divisions_parent_fk')
                ->on('divisions')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        //Должности
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id')->nullable(true);
            $table->string('title')->nullable(false);
            $table->timestamps();

            $table
                ->foreign('division_id', 'positions_division_fk')
                ->on('divisions')
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
    }
};
