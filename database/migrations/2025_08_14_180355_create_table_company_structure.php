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
            $table->string('title')->nullable(false);
            $table->integer('parent_id')->nullable(true)->comment('For sorting');
            $table->integer('lft')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('rgt')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('depth')->default(0)->nullable(false)->comment('For sorting');
            $table->timestamps();
        });

        //Подразделения
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->integer('parent_id')->nullable(true)->comment('For sorting');
            $table->integer('lft')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('rgt')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('depth')->default(0)->nullable(false)->comment('For sorting');
            $table->timestamps();
        });

        Schema::create('company_rel_division', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable(true);
            $table->unsignedBigInteger('division_id')->nullable(true);

            $table
                ->foreign('company_id', 'company_rel_division_company_fk')
                ->on('companies')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('division_id', 'company_rel_division_division_fk')
                ->on('divisions')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        //Должности
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->timestamps();
        });

        Schema::create('division_rel_position', function (Blueprint $table) {
            $table->unsignedBigInteger('division_id')->nullable(true);
            $table->unsignedBigInteger('position_id')->nullable(true);

            $table
                ->foreign('division_id', 'division_rel_position_division_fk')
                ->on('divisions')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('position_id', 'division_rel_position_position_fk')
                ->on('positions')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
