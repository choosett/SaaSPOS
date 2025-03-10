<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ✅ Ensure table names are loaded before use
        $tableNames = config('permission.table_names') ?? [];
        $columnNames = config('permission.column_names') ?? [];
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        // ✅ Throw an error if config is not loaded properly
        if (empty($tableNames) || !isset($tableNames['permissions'], $tableNames['roles'])) {
            throw new \Exception('Error: `config/permission.php` is not loaded. Run: php artisan config:clear and try again.');
        }

        // ✅ Step 1: Create `permissions` table first
        if (!Schema::hasTable($tableNames['permissions'])) {
            Schema::create($tableNames['permissions'], function (Blueprint $table) {
                $table->id();
                $table->string('business_id', 8)->nullable();
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->timestamps();
                $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade');
                $table->unique(['name', 'business_id']);
            });
        }

        // ✅ Step 2: Create `roles` table before relationships
        if (!Schema::hasTable($tableNames['roles'])) {
            Schema::create($tableNames['roles'], function (Blueprint $table) {
                $table->id();
                $table->string('business_id', 8)->nullable();
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->timestamps();
                $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade');
                $table->unique(['name', 'business_id']);
            });
        }

        // ✅ Step 3: Create `role_has_permissions` after `roles` and `permissions`
        if (!Schema::hasTable($tableNames['role_has_permissions'])) {
            Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');
                $table->foreign('permission_id')->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on($tableNames['roles'])->onDelete('cascade');
                $table->primary(['permission_id', 'role_id']);
            });
        }

        // ✅ Step 4: Create `model_has_permissions` after `permissions`
        if (!Schema::hasTable($tableNames['model_has_permissions'])) {
            Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($columnNames, $tableNames) {
                $table->unsignedBigInteger('permission_id');
                $table->string('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index([$columnNames['model_morph_key'], 'model_type']);
                $table->foreign('permission_id')->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type']);
            });
        }

        // ✅ Step 5: Create `model_has_roles` after `roles`
        if (!Schema::hasTable($tableNames['model_has_roles'])) {
            Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($columnNames, $tableNames) {
                $table->unsignedBigInteger('role_id');
                $table->string('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index([$columnNames['model_morph_key'], 'model_type']);
                $table->foreign('role_id')->references('id')->on($tableNames['roles'])->onDelete('cascade');
                $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type']);
            });
        }
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php missing.');
        }

        // ✅ Drop all tables in reverse order
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
};
