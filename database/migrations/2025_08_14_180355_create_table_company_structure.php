<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Dictionaries\CompanyStructure\CompanyStructureTypeFlagDictionary;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_structure_types', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->json('flags')->nullable(true);
            $table->integer('parent_id')->nullable(true)->comment('Parent entity');
            $table->integer('lft')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('rgt')->default(0)->nullable(false)->comment('For sorting');
            $table->integer('depth')->default(0)->nullable(false)->comment('For sorting');
        });

        Schema::create('company_structure_types_rel', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable(true)->comment('Parent entity');
            $table->unsignedBigInteger('rel_type_id')->nullable(true)->comment('Related entity');

            $table
                ->foreign('type_id', 'company_structure_types_rel_type_fk')
                ->on('company_structure_types')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('rel_type_id', 'company_structure_types_rel_rel_type_fk')
                ->on('company_structure_types')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('company_structure', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->nullable('false');
            $table->string('title')->nullable(false);
            $table->timestamps();

            $table
                ->foreign('type_id', 'company_structure_type_fk')
                ->on('company_structure_types')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('company_structure_rel', function (Blueprint $table) {
            $table->unsignedBigInteger('structure_id')->nullable(true)->comment('Parent entity');
            $table->unsignedBigInteger('structure_rel_id')->nullable(true)->comment('Related entity');

            $table
                ->foreign('structure_id', 'company_structure_rel_fk')
                ->on('company_structure')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('structure_rel_id', 'company_structure_rel_rel_fk')
                ->on('company_structure')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        DB::table('company_structure_types')
            ->insert([
                'id'        => 1,
                'title'     => 'Локация',
                'slug'      => Str::slug('location'),
                'flags'     => json_encode([CompanyStructureTypeFlagDictionary::DISABLE_DELETION]),
                'parent_id' => null,
                'lft'       => 0,
                'rgt'       => 0,
                'depth'     => 0,
            ]);
        DB::table('company_structure_types')
            ->insert([
                'id'        => 2,
                'title'     => 'Отдел',
                'slug'      => Str::slug('department'),
                'flags'     => json_encode([CompanyStructureTypeFlagDictionary::DISABLE_DELETION]),
                'parent_id' => null,
                'lft'       => 0,
                'rgt'       => 0,
                'depth'     => 0,
            ]);
        DB::table('company_structure_types')
            ->insert([
                'id'        => 3,
                'title'     => 'Должность',
                'slug'      => Str::slug('position'),
                'flags'     => json_encode([CompanyStructureTypeFlagDictionary::DISABLE_DELETION, CompanyStructureTypeFlagDictionary::ASSOCIATE_WITH_PSYCHOTYPES]),
                'parent_id' => null,
                'lft'       => 0,
                'rgt'       => 0,
                'depth'     => 0,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_structure_types', function (Blueprint $table) {
            $table->dropForeign('company_structure_type_fk');
        });
        Schema::table('company_structure', function (Blueprint $table) {
            $table->dropForeign('company_structure_parent_fk');
        });
        Schema::dropIfExists('company_structure');
        Schema::dropIfExists('company_structure_types');
    }
};
