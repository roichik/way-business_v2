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
        Schema::create('user_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->json('flags')->nullable(true);
            $table->timestamps();

            $table
                ->foreign('user_id', 'user_access_user_fk')
                ->on('users')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create('user_access_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('user_access_id')->nullable(false);
            $table->unsignedBigInteger('access_group_id')->nullable(false);

            $table
                ->foreign('user_access_id', 'user_access_groups_ua_fk')
                ->on('user_access')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('access_group_id', 'user_access_groups_ag_fk')
                ->on('admin_access_groups')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create('user_access_group_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_access_id')->nullable(false);
            $table->unsignedBigInteger('role_id')->nullable(false);

            $table
                ->foreign('user_access_id', 'user_access_group_roles_ua_fk')
                ->on('user_access')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('role_id', 'user_access_group_roles_role_fk')
                ->on('admin_roles')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create('user_access_group_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_access_id')->nullable(false);
            $table->unsignedBigInteger('permission_id')->nullable(false);

            $table
                ->foreign('user_access_id', 'user_access_group_permissions_ua_fk')
                ->on('user_access')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('permission_id', 'user_access_group_permissions_p_fk')
                ->on('admin_permissions')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create('user_access_group_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_access_id')->nullable(false);
            $table->unsignedBigInteger('company_id')->nullable(false);

            $table
                ->foreign('user_access_id', 'user_access_group_companies_ua_fk')
                ->on('admin_access_groups')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreign('company_id', 'user_access_group_companies_c_fk')
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
        Schema::dropIfExists('user_access_group_companies');
        Schema::dropIfExists('user_access_group_permissions');
        Schema::dropIfExists('user_access_group_roles');
        Schema::dropIfExists('user_access_groups');
        Schema::dropIfExists('user_access');
    }
};
