<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            if (!\Illuminate\Support\Facades\App::environment('testing')) {
                throw new \ErrorException('`users` table is missing.');
            }
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->default(null)->after('id');
            $table->string('mobile')->nullable()->after('name');
            $table->string('login_id')->unique()->after('email');
            $table->unsignedSmallInteger('wrong_password')->default(0)->after('password');
            $table->string('pin')->after('wrong_password');
            $table->unsignedSmallInteger('wrong_pin')->default(0)->after('pin');
            $table->string('status')->nullable()->after('wrong_pin');
            $table->string('language')->nullable()->after('status');
            $table->string('currency')->nullable()->after('language');
            $table->string('app_version')->default('1')->nullable();
            $table->string('fcm_token')->nullable()->after('remember_token');
            $table->timestamp('mobile_verified_at')->nullable()->after('email_verified_at');
            $table->foreignId('creator_id')->nullable()->after('mobile_verified_at');
            $table->foreignId('editor_id')->nullable()->after('creator_id');
            $table->foreignId('destroyer_id')->nullable()->after('editor_id');
            $table->foreignId('restorer_id')->nullable()->after('destroyer_id');
            $table->softDeletes()->after('updated_at');
            $table->timestamp('restored_at')->nullable()->after('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('parent_id');
                $table->dropColumn('mobile');
                $table->dropColumn('login_id');
                $table->dropColumn('wrong_password');
                $table->dropColumn('pin');
                $table->dropColumn('wrong_pin');
                $table->dropColumn('status');
                $table->dropColumn('language');
                $table->dropColumn('currency');
                $table->dropColumn('app_version');
                $table->dropColumn('fcm_token');
                $table->dropColumn('mobile_verified_at');
                $table->dropColumn('creator_id');
                $table->dropColumn('editor_id');
                $table->dropColumn('destroyer_id');
                $table->dropColumn('restorer_id');
                $table->dropColumn('deleted_at');
                $table->dropColumn('restored_at');
            });
        }
    }
};
