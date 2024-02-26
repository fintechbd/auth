<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (!$teams) {
            return;
        }

        if (empty($tableNames)) {
            throw new Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if (empty($columnNames['team_foreign_key'] ?? null)) {
            throw new Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->foreignId('editor_id')->nullable();
            $table->foreignId('destroyer_id')->nullable();
            $table->foreignId('restorer_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('restored_at')->nullable();
        });

        if (!Schema::hasColumn($tableNames['roles'], $columnNames['team_foreign_key'])) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($columnNames) {
                $table->foreignId($columnNames['team_foreign_key'])->nullable()->after('id');
                $table->dropUnique('roles_name_guard_name_unique');
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            });
        }

        if (!Schema::hasColumn($tableNames['model_has_permissions'], $columnNames['team_foreign_key'])) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
                $table->foreignId($columnNames['team_foreign_key'])->default('1');

                if (DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign([PermissionRegistrar::$pivotPermission]);
                }
                $table->dropPrimary();
                $table->primary(
                    [$columnNames['team_foreign_key'], PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary'
                );
                if (DB::getDriverName() !== 'sqlite') {
                    $table->foreign(PermissionRegistrar::$pivotPermission)
                        ->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                }
            });
        }

        if (!Schema::hasColumn($tableNames['model_has_roles'], $columnNames['team_foreign_key'])) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
                $table->foreignId($columnNames['team_foreign_key'])->default('1');
                if (DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign([PermissionRegistrar::$pivotRole]);
                }
                $table->dropPrimary();

                $table->primary(
                    [$columnNames['team_foreign_key'], PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary'
                );

                if (DB::getDriverName() !== 'sqlite') {
                    $table->foreign(PermissionRegistrar::$pivotRole)
                        ->references('id')->on($tableNames['roles'])->onDelete('cascade');
                }
            });
        }

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
