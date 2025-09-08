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
        Schema::create('admin_access_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 1000)->nullable(true);
            $table->json('flags')->nullable(true);
            $table->timestamps();
        });

        Schema::create('admin_access_group_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('access_group_id')->nullable(false);
            $table->unsignedBigInteger('role_id')->nullable(false);

            $table
                ->foreign('access_group_id', 'admin_access_group_roles_ag_fk')
                ->on('admin_access_groups')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('role_id', 'admin_access_group_roles_role_fk')
                ->on('admin_roles')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create('admin_access_group_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('access_group_id')->nullable(false);
            $table->unsignedBigInteger('permission_id')->nullable(false);

            $table
                ->foreign('access_group_id', 'admin_access_permissions_ag_fk')
                ->on('admin_access_groups')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('permission_id', 'admin_access_group_permissions_p_fk')
                ->on('admin_permissions')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create('admin_access_group_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('access_group_id')->nullable(false);
            $table->unsignedBigInteger('company_id')->nullable(false);

            $table
                ->foreign('access_group_id', 'admin_access_group_companies_ag_fk')
                ->on('admin_access_groups')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('company_id', 'admin_access_group_companies_c_fk')
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
        Schema::dropIfExists('admin_access_group_companies');
        Schema::dropIfExists('admin_access_group_permissions');
        Schema::dropIfExists('admin_access_group_roles');
        Schema::dropIfExists('admin_access_groups');
    }
};
